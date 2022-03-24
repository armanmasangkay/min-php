<?php namespace App\Source\Atom;

// This class will serve as the templating engine

class Vision{

    public static function parse($contents)
    {
        //Get the contents of the file
        $contents=file_get_contents($contents);

        //Look if the file has something to be parsed
        preg_match_all("/{{.*}}/",$contents,$matches);
        $parsables=$matches[0];

        if(!empty($parsables)){
            //We then replace the part that was parsed with the output. We do this for every content of the file that needs to be part
            foreach ($parsables as $parsable){
        
                $parsedCode=preg_replace(['/{{/','/}}/'],['echo "','";'],$parsable);
                ob_start();
                eval($parsedCode);
                $output = ob_get_contents();
                ob_end_clean();
        
                //Escape some brackets and the dollar sign if what is inside the bracket is a variable
                $patterns=[
                    "/^{/",
                    "/}$/",
                    "/\\$/"
                ];
        
                $replacements=[
                    "\{",
                    "\}",
                    '\\\\$'
                ];
        
                $escaped=preg_replace($patterns,$replacements,$parsable);
                $contents = preg_replace("/$escaped/", $output, $contents);
        
            }
            //Show the new file with the parsed data
            return $contents;
        }else{
            // return the content if there is nothing to be parsed
            return $contents;
        }
    }

}