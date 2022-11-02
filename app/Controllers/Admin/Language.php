<?php

namespace App\Controllers\Admin;


class Language extends BaseController
{
    /*
     * Quan ly language
     */

    public function index()
    {
        $translations = $this->_load_language();

        $this->data['moduleData'] = $translations;

        //echo "<pre>";
        //print_r($this->data['moduleData']);
        //die();
        return view($this->data['content'], $this->data);
    }

    public function savelanguage()
    {
        if (!isset($_POST['data'])) {
            return;
        }
        //print_r($_POST['data']);
        //die();
        $data = json_decode($_POST['data'], true);

        foreach ($data as $lang => $row) {
            //print_r($row);
            //die();
            $path = APPPATH . "language/" . $lang . "/Custom.php";
            // Backup original file
            if (is_file($path)) {
                $slaveModule = $this->_load_module($path);
                $fp = fopen($path . '.' . date('Y-M-d-H-i-s') . '.bak', 'w');
                fwrite($fp, implode($slaveModule));
                fclose($fp);
            }
            $master = array();
            $master[] = "<?php \n\n";
            foreach ($row as $key => $value) {
                $master[] = "\$lang['" . $key . "'] = \"$value\";";
            }
            // Add closing PHP tag
            $master[] = "return \$lang;";
            $master[] = NULL;
            $master[] = NULL;
            $master[] = "\n\n?>";

            // Clean up new line characters from textarea inputs
            foreach ($master as $line_number => $line) {
                $master[$line_number] = str_replace("\n", '', $line);
                $master[$line_number] .= "\n";
            }
            // Check syntax and attempt to save file
            $php = implode($master);
            //echo $php;
            //die();
            if (!$this->_invalid_php_syntax($php)) {
                $fp = @fopen($path, 'w');
                if (fwrite($fp, $php) !== FALSE) {
                    fclose($fp);
                }
            }
        }
        echo json_encode(1);
    }

    function _load_language()
    {
        $translations = array();
        $array_lang = config("App")->supportedLocales;
        //print_r($array_lang);
        //die();
        foreach ($array_lang as $k) {
            $path = APPPATH . "Language/" . $k . "/Custom.php";
            //            echo $path;
            $masterModule = $this->_load_module($path);
            foreach ($masterModule as $lineNumber => $line) {
                // Extract each key and value
                if ($this->_is_lang_key($line)) {
                    $key = $this->_get_lang_key($line);
                    $translations[$key][$k] = $this->_get_lang($line);
                }
            }
        }
        return $translations;
    }

    function _load_module($modulePath)
    {

        /* TODO: Add error checking for non-existent files? */

        $module = @file($modulePath);

        return $module;
    }

    /**
     * Determine if a line of PHP code contains a translation key
     *
     * @param $line string
     * @return boolean
     */
    function _is_lang_key($line)
    {
        $line = trim($line);
        if (empty($line) || mb_stripos($line, '$lang[') === FALSE) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Extract translation key from a line of PHP code
     *
     * @param $line string
     * @return string
     */
    function _get_lang_key($line)
    {
        // Trim forward to the first quote mark
        $line = trim(mb_substr($line, mb_strpos($line, '[') + 1));
        // Trim forward to the second quote mark
        $line = trim(mb_substr($line, 0, mb_strpos($line, ']')));
        return mb_substr($line, 1, mb_strlen($line) - 2);
    }

    /**
     * Extract translation string from a line of PHP code
     *
     * @param $line string
     * @return string
     */
    function _get_lang($line)
    {

        /* Agricultural solution */
        // Trim forward to the first quote mark
        $line = trim(mb_substr($line, strpos($line, '=') + 1));
        // Trim backward from the semi-colon
        $line = mb_substr($line, 0, mb_strrpos($line, ';'));
        $line = trim($line, '\'"');
        /* TODO - This is no good if the string is a PHP expression e.g. 'Hello, ' + CONST + ' how\'s your world?'
          // Trim any encapsulating quote marks
          $line = trim( $line, '\'"' );
         */

        /* Regex based solution ?
          $pattern = '/[^=]*=\s*[\'"]?(.*)[\'"]?;$/';
          $pattern = '/[^=]*=\s*[\'"]?(.*);$/';
          preg_match($pattern, $line, $matches);
          $line = $matches[ 1 ];

          $pattern = '/^[\'"]?(.*)[\'"]{1}$/';
          preg_match($pattern, $line, $matches);
          if ( count( $matches ) >= 1 ) {
          $line = $matches[ 1 ];
          }
         */

        return $this->_escape_templates($line);
    }

    /**
     * Escape template tags
     *
     * @return string
     */
    function _escape_templates($line)
    {
        return preg_replace('/{(.*)}/', '\\{$1\\}', $line);
    }

    /**
     * Unescape template tags
     *
     * @return string
     */
    function _unescape_templates($line)
    {
        return preg_replace('/\\\{(.*)\\\}/', '{$1}', $line);
    }

    /**
     * Check PHP syntax
     *
     * Returns FALSE if no errors found otherwise returns the line number of the
     * error with the error message and bad code in variables passed by reference
     *
     * @param $php string
     * @return int
     */
    function _invalid_php_syntax($php, &$err = '', &$bad_code = '')
    {

        // Remove opening and closing PHP tags
        $php = str_replace('<?php', '', $php);
        $php = str_replace('?>', '', $php);

        // Evaluate the code
        ob_start();
        eval($php);
        $err = ob_get_contents();
        ob_end_clean();

        if (!empty($err)) {
            if (mb_stripos($err, 'Parse error') == FALSE) {
                return FALSE;
            }
        }
        // Remove any html tags returned in error message
        $err_text = strip_tags($err);

        // Get the line number
        $line = (int) trim(substr($err_text, strripos($err_text, ' ')));

        $php = explode("\n", $php);

        $bad_code = $php[max(0, $line - 1)];

        return $line;
    }
}
