<?php
	class Security
	{
		/**
     * escapes special chars in datas got from input
     * @param PDO object
     * @param string $string datas
     * @return string
     */
		public static function bdd($string)
		{
			if(ctype_digit($string))
			{
				$string = intval($string);
			}
			else
			{
				// $string = $db -> quote($string);
				$string = addcslashes($string, '%_');
			}

			return $string;

		}

    /**
     * use of htmlentities()
     * @param  string $string
     * @return string
     */
		public static function html($string)
		{
			return htmlentities($string);
		}
	}
