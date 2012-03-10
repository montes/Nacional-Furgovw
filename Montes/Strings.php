<?php
/*
 * This is an UTF-8 file
 * 
 * This file is part of the montes utility library
 * 
 * (C) Javier Montes <kalimocho@gmail.com> 
 *
 * Twitter: @mooontes
 * Web: http://mooontes.com
 * 
 * "Montes Library" is licensed under GPL 2.0 
 * http://www.gnu.org/licenses/gpl-2.0.html
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * 
 */

namespace Montes;

class Strings
{
	private static $_string = false;
	private static $_encoding = 'UTF-8'; //UTF8 is our default encoding
	
	/**
	 * Prevent class instantiating, we are static!
	 */
	private function __construct()
	{
	}
	
	public static function filter($filter, $string = false, $param = false)
	{
		if ($string !== false) {
			self::autoDetectEncoding($string);
		}
		
		switch($filter) {
			case 'TILDES':
				return self::removeTildes();
				break;
			case 'CLEAN_SPACES':
				return self::cleanSpaces();
				break;
			case 'PHRASE_CUT':
				return self::phraseCut(self::$_string, $param);
				break;
			case 'PHRASE_CUT_OUT':
				return self::phraseCut(self::$_string, $param, true);
				break;
			case 'NOT_LETTERS-NUMBERS-SPACE':
				return self::removeNotLettersNumbersSpace();
				break;
			case 'NOT_NUMBERS-DOT-COMMA-SLASH':
				return self::removeNotNumbersDotCommaSlash();
				break;
			case 'NOT_LETTERS-NUMBERS-SPACE-SLASH':
				return self::removeNotLettersNumbersSpaceSlash();
				break;
			case 'NOT_ASCIILETTERS-NUMBERS-SPACE-SLASH':
				return self::removeNotAsciiLettersNumbersSpaceSlash();
				break;
			case 'NOT_LETTERS-NUMBERS-PUNCTUATION':
				return self::removeNotLettersNumbersPunctuation();
				break;
			case 'NOT_LETTERS-NUMBERS-SPACE-PUNCTUATION':
				return self::removeNotLettersNumbersSpacePunctuation();
				break;
			case 'NOT_ASCIILETTERS-NUMBERS-SPACE-PUNCTUATION':
				return self::removeNotAsciiLettersNumbersSpacePunctuation();
				break;
			case 'MAKE_URL_STRING':
				return self::makeUrlString($param);
				break;
			case '':
				return false;
				break;
			default:
				return filter_var(self::$_string, $filter);
				break;
		}
	}

	public static function setString($string)
	{
		if (mb_strlen($string) > 0) {
			self::autoDetectEncoding($string);
		}
		else {
			return false;
		}
	}
	
	public static function setEncoding($encoding)
	{
		//TODO: controlar q el encoding q nos pasa es válido
		self::$_encoding = $encoding;
		mb_internal_encoding($encoding);
	}
	
	public static function autoDetectEncoding($string = null)
	{
		if ($string !== null) {
			self::$_string = $string;
		}
		
		self::$_encoding = mb_detect_encoding(self::$_string);
		
		if (!self::$_encoding) {
			throw new Exception ('Error detecting encoding');
		}
		
		self::setEncoding(self::$_encoding);
	}
	
	/**
	 * 
	 * Cuts a phrase to the maximum length of $max, cutting only through spaces
	 * 
	 * If not spaces found and strlen > $max it returns exactly $max chars
	 * If $string is empty or $maxLenth is not int, it returns false
	 *  
	 * @param string $string
	 * @param int $max
	 * @param bool $cutOutNonStringChars
	 */
	private static function phraseCut($string, $maxLength, $cutOutNonStringChars = false)
	{
		if ($string !== false) {
			self::autoDetectEncoding($string);
		}
		
		if (mb_strlen(self::$_string) < 1 || !is_numeric($maxLength)) {
			return false;
		}
		
		self::$_string = self::cleanSpaces();
		
		switch($cutOutNonStringChars) {
			case true:
				$regex = '%(?P<word>[\p{L}0-9&\.\-,;]+)%u';
				break;
			default:
				$regex = '%(?P<word>[\S]+)%u';
				break;
		}
		
		if (preg_match_all($regex, self::$_string, $result)) { // \p{L} -> same as \w but supporting utf (ñ, á, etc...)
			$cutPhrase = '';
			for ($i = 0; 
				($i < count($result['word']) && mb_strlen($cutPhrase.$result['word'][$i]) <= $maxLength);
				$i++) {

				$cutPhrase .= $result['word'][$i] . ' ';
			}
			if (mb_strlen($cutPhrase) < 1)
			{
				$cutPhrase = mb_substr(self::$_string, 0, $maxLength);
			}
			return trim($cutPhrase);
		}
		else {
			return false;
		}
	}
	
	/**
	 * 
	 * Turns more than one contigous space in one space, also does trim string
	 * ex.: " onestring   twostring " -> "onestring twostring"
	 *
	 */
	private static function cleanSpaces()
	{
		return trim(preg_replace('/\s+/', ' ', self::$_string));
	}
	
	private static function removeTildes()
	{
		$withTildes = array('á', 'à', 'â', 'ã', 'ä', 'ª', 'é', 'è', 'ê', 'ë',
			'í', 'ì', 'î', 'ï', 'ó', 'ò', 'ô', 'õ', 'ö', 'º', 'ú', 'ù', 'û',
			'ü', 'Á', 'À', 'Â', 'Ã', 'Ä', 'É', 'È', 'Ê', 'Ë', 'Í', 'Ì', 'Î',
			'Ï', 'Ó', 'Ò', 'Ô', 'Õ', 'Ö', 'Ú', 'Ù', 'Û', 'Ü', 'ñ', 'Ñ', 'ç',
			'Ç');
		
		$withoutTildes = array('a', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e',
			'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u',
			'u', 'u', 'A', 'A', 'A', 'A', 'A', 'E', 'E', 'E', 'E', 'I', 'I',
			'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'n', 'N',
			'c', 'C');
		
		return str_replace($withTildes, $withoutTildes, self::$_string);
	}

	private static function removeNotLettersNumbersSpace()
	{
		return preg_replace("%[^\p{L}0-9\s]%u", "", self::$_string);
	}

	private static function removeNotNumbersDotCommaSlash()
	{
		return preg_replace("%[^0-9\.,\-]%u", "", self::$_string);
	}

	private static function removeNotLettersNumbersSpaceSlash()
	{
		return preg_replace("%[^\p{L}0-9\s\-]%u", "", self::$_string);
	}

	private static function removeNotAsciiLettersNumbersSpaceSlash()
	{
		return preg_replace("%[^a-zA-Z0-9\s\-]%u", "", self::$_string);
	}
	
	private static function removeNotLettersNumbersPunctuation()
	{
		return preg_replace("%[^\p{L}0-9\.\-,;\:\/¿?¡!\"']%u", "", self::$_string);
	}

	private static function removeNotLettersNumbersSpacePunctuation()
	{
		return preg_replace("%[^\p{L}0-9\s\.\-,;\:\/¿?¡!\"']%u", "", self::$_string);
	}
	
	private static function removeNotAsciiLettersNumbersSpacePunctuation()
	{
		return preg_replace("%[^a-zA-Z0-9\s\.\-,;\:\/¿?¡!\"']%u", "", self::$_string);
	}
	
	private static function makeUrlString($max)
	{
		$urlString = self::$_string;
		self::$_string = mb_strtolower(self::$_string);
		self::$_string = self::removeTildes(self::$_string);
		self::$_string = self::removeNotAsciiLettersNumbersSpaceSlash();
		self::$_string = trim(self::$_string);
		
		if ($max > 0) {
			self::$_string = self::phraseCut(self::$_string, $max);
		}
		
		self::$_string = str_replace(" ", "-", self::$_string);
		self::$_string = preg_replace("%(-+)%u","-",self::$_string);
		
		return self::$_string;
	}




}
