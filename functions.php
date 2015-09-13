<?php

    require("magic.php");

    /**
     * Executes SQL statement, possibly with parameters, returning
     * an array of all rows in result set or false on (non-fatal) error.
     */
    function query(/* $sql [, ... ] */)
    {
        // SQL statement
        $sql = func_get_arg(0);

        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);

        // try to connect to database
        static $handle;
        if (!isset($handle))
        {
            try
            {
                // connect to database
                // 可能會在非 80 port 開發，若 server 不是 www.coursentnu.com 的話，就直接進 else
                if ($_SERVER['HTTP_HOST']=="www.coursentnu.com")
                {
                  $handle = new PDO("mysql:dbname=coursentnu;host=localhost;port=3306", USERNAME, PASSWORD);
                }
                else
                {
                  // 記得更改 unix_socket，可以進 mySQL 後用 show variables like '%sock%'; 來看
                  // $usocket = "/Applications/MAMP/tmp/mysql/mysql.sock";
                  $handle = new PDO("mysql:dbname=testing;host=localhost;unix_socket=".USOCKET.";port=3306", USERNAME, PASSWORD);
                }

                // ensure that PDO::prepare returns false when passed invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                // 避免撈出來的中文字變成問號
                $handle->exec("set names utf8");
            }
            catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
                exit;
            }
        }

        // prepare SQL statement
        $statement = $handle->prepare($sql);
        if ($statement === false)
        {
          echo "error";
            // trigger (big, orange) error
            trigger_error($handle->errorInfo()[2], E_USER_ERROR);
            exit;
        }

        // execute SQL statement
        $results = $statement->execute($parameters);

        // return result set's rows, if any
        if ($results !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    /**
     * Renders template, passing in values.
     */
    function render($template, $values = [])
    {
        // if template exists, render it
        if (file_exists("template/$template"))
        {
            // extract variables into local scope
            extract($values);

            // render header
            require("template/header.php");

            // render template
            require("template/$template");

            // render footer
            require("template/footer.php");
        }

        // else err
        else
        {
            trigger_error("Invalid template: $template", E_USER_ERROR);
        }
    }

    /**
     * Redirects user to destination, which can be
     * a URL or a relative path on the local host.
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     */
    function redirect($destination)
    {
        // handle URL
        if (preg_match("/^https?:\/\//", $destination))
        {
            header("Location: " . $destination);
        }

        // handle absolute path
        else if (preg_match("/^\//", $destination))
        {
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            header("Location: $protocol://$host$destination");
        }

        // handle relative path
        else
        {
            // adapted from http://www.php.net/header
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            header("Location: $protocol://$host$path/$destination");
        }

        // exit immediately since we're redirecting anyway
        exit;
    }

    function lookup($token)
    {
        $url_with_token = "https://graph.facebook.com/me?access_token=" . $token;
        $result = json_decode(file_get_contents($url_with_token), true);
        if (isset($result["id"]))
        {
            return $result;
        }
        else
        {
            return false;
        }
    }

?>
