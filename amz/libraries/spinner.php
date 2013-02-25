 <?php
set_time_limit(10);
function inStr($needle, $haystack){
    return @strpos($haystack, $needle) !== false;
}
function str_replaceFirst($s,$r,$str){
    $l = strlen($str);
    $a = strpos($str,$s);
    $b = $a + strlen($s);
    $temp = substr($str,0,$a) . $r . substr($str,$b,($l-$b));
    return $temp;
}
function spin($pass){
    $mytext = $pass;
    while(inStr("}",$mytext)){
        $rbracket = strpos($mytext,"}",0);
        $tString = substr($mytext,0,$rbracket);
        $tStringToken = explode("{",$tString);
        $tStringCount = count($tStringToken) - 1;
        $tString = $tStringToken[$tStringCount];
        $tStringToken = explode("|",$tString);
        $tStringCount = count($tStringToken) - 1;
        $i = rand(0,$tStringCount);
        $replace = $tStringToken[$i];
        $tString = "{".$tString."}";
        $mytext = str_replaceFirst($tString,$replace,$mytext);
    }
    return $mytext;
}

echo '<form action="" method="post"><textarea name="mypost" cols="80" rows="20">';

if(isset($_POST["mypost"])){
    echo $_POST["mypost"];
}
echo '</textarea><br /><input name="" type="submit" /></form>';

if(isset($_POST["mypost"])){
    $mypost = $_POST["mypost"];
    $mypost = str_replace("'","`",$mypost);
    $echoMe = spin($mypost);
    $wordCount = explode(" ",$echoMe);
    $wordCount = count($wordCount);
    $echoMe = str_replace(chr(13).chr(10),"<br />".chr(13).chr(10),$echoMe);
    echo $echoMe;
    echo "<br />";
    echo "wordcount: <b>$wordCount</b>";

}

// Another class
class Spinner
{
    # Detects whether to use the nested or flat version of the spinner (costs some speed)
    public static function detect($text, $seedPageName = true, $openingConstruct = '{{', $closingConstruct = '}}', $separator = '|')
    {
        if(preg_match('~'.$openingConstruct.'(?:(?!'.$closingConstruct.').)*'.$openingConstruct.'~s', $text))
        {
            return self::nested($text, $seedPageName, $openingConstruct, $closingConstruct, $separator);
        }
        else
        {
            return self::flat($text, $seedPageName, false, $openingConstruct, $closingConstruct, $separator);
        }
    }

    # The flat version does not allow nested spin blocks, but is much faster (~2x)
    public static function flat($text, $seedPageName = true, $calculate = false, $openingConstruct = '{{', $closingConstruct = '}}', $separator = '|')
    {
        # Choose whether to return the string or the number of permutations
        $return = 'text';
        if($calculate)
        {
            $permutations   = 1;
            $return         = 'permutations';
        }

        # If we have nothing to spin just exit (don't use a regexp)
        if(strpos($text, $openingConstruct) === false)
        {
            return $$return;
        }
       
        if(preg_match_all('!'.$openingConstruct.'(.*?)'.$closingConstruct.'!s', $text, $matches))
        {
            # Optional, always show a particular combination on the page
            self::checkSeed($seedPageName);

            $find       = array();
            $replace    = array();

            foreach($matches[0] as $key => $match)
            {
                $choices = explode($separator, $matches[1][$key]);

                if($calculate)
                {
                    $permutations *= count($choices);
                }
                else
                {
                    $find[]     = $match;
                    $replace[]  = $choices[mt_rand(0, count($choices) - 1)];
                }
            }

            if(!$calculate)
            {
                # Ensure multiple instances of the same spinning combinations will spin differently
                $text = self::str_replace_first($find, $replace, $text);
            }
        }

        return $$return;
    }

    # The nested version allows nested spin blocks, but is slower
    public static function nested($text, $seedPageName = true, $openingConstruct = '{{', $closingConstruct = '}}', $separator = '|')
    {
        # If we have nothing to spin just exit (don't use a regexp)
        if(strpos($text, $openingConstruct) === false)
        {
            return $text;
        }

        # Find the first whole match
        if(preg_match('!'.$openingConstruct.'(.+?)'.$closingConstruct.'!s', $text, $matches))
        {
            # Optional, always show a particular combination on the page
            self::checkSeed($seedPageName);

            # Only take the last block
            if(($pos = mb_strrpos($matches[1], $openingConstruct)) !== false)
            {
                $matches[1] = mb_substr($matches[1], $pos + mb_strlen($openingConstruct));
            }

            # And spin it
            $parts  = explode($separator, $matches[1]);
            $text   = self::str_replace_first($openingConstruct.$matches[1].$closingConstruct, $parts[mt_rand(0, count($parts) - 1)], $text);

            # We need to continue until there is nothing left to spin
            return self::nested($text, $seedPageName, $openingConstruct, $closingConstruct, $separator);
        }
        else
        {
            # If we have nothing to spin just exit
            return $text;
        }
    }

    # Similar to str_replace, but only replaces the first instance of the needle
    private static function str_replace_first($find, $replace, $string)
    {
        # Ensure we are dealing with arrays
        if(!is_array($find))
        {
            $find = array($find);
        }

        if(!is_array($replace))
        {
            $replace = array($replace);
        }

        foreach($find as $key => $value)
        {
            if(($pos = mb_strpos($string, $value)) !== false)
            {
                # If we have no replacement make it empty
                if(!isset($replace[$key]))
                {
                    $replace[$key] = '';
                }

                $string = mb_substr($string, 0, $pos).$replace[$key].mb_substr($string, $pos + mb_strlen($value));
            }
        }

        return $string;
    }

    private static function checkSeed($seedPageName)
    {
        # Don't do the check if we are using random seeds
        if($seedPageName)
        {
            if($seedPageName === true)
            {
                mt_srand(crc32($_SERVER['REQUEST_URI']));
            }
            elseif($seedPageName == 'every second')
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].date('Y-m-d-H-i-s')));
            }
            elseif($seedPageName == 'every minute')
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].date('Y-m-d-H-i')));
            }
            elseif($seedPageName == 'hourly' OR $seedPageName == 'every hour')
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].date('Y-m-d-H')));
            }
            elseif($seedPageName == 'daily' OR $seedPageName == 'every day')
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].date('Y-m-d')));
            }
            elseif($seedPageName == 'weekly' OR $seedPageName == 'every week')
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].date('Y-W')));
            }
            elseif($seedPageName == 'monthly' OR $seedPageName == 'every month')
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].date('Y-m')));
            }
            elseif($seedPageName == 'annually' OR $seedPageName == 'every year')
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].date('Y')));
            }
            elseif(preg_match('!every ([0-9.]+) seconds!', $seedPageName, $matches))
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].floor(time() / $matches[1])));
            }
            elseif(preg_match('!every ([0-9.]+) minutes!', $seedPageName, $matches))
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].floor(time() / ($matches[1] * 60))));
            }
            elseif(preg_match('!every ([0-9.]+) hours!', $seedPageName, $matches))
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].floor(time() / ($matches[1] * 3600))));
            }
            elseif(preg_match('!every ([0-9.]+) days!', $seedPageName, $matches))
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].floor(time() / ($matches[1] * 86400))));
            }
            elseif(preg_match('!every ([0-9.]+) weeks!', $seedPageName, $matches))
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].floor(time() / ($matches[1] * 604800))));
            }
            elseif(preg_match('!every ([0-9.]+) months!', $seedPageName, $matches))
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].floor(time() / ($matches[1] * 2620800))));
            }
            elseif(preg_match('!every ([0-9.]+) years!', $seedPageName, $matches))
            {
                mt_srand(crc32($_SERVER['REQUEST_URI'].floor(time() / ($matches[1] * 31449600))));
            }
            else
            {
                throw new Exception($seedPageName. ' Was not a valid spin time option!');
            }
        }
    }
}

$string = '{{The|A}} {{quick|speedy|fast}} {{brown|black|red}} {{fox|wolf}} {{jumped|bounded|hopped|skipped}} over the {{lazy|tired}} {{dog|hound}}';

echo '<p>';

for($i = 1; $i <= 5; $i++)
{
    echo Spinner::detect($string, false).'<br />';
    // or Spinner::flat($string, false).'<br />';
}

echo '</p>';

?> 