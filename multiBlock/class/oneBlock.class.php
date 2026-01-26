<?php

class OneBlock {
	
	/**
	 * Get current site language with I18N plugin support
	 * @return string Language code (e.g., 'pl', 'en', 'de')
	 */
	private function getCurrentLanguage() {
		// Priority 1: I18N plugin - return_i18n_languages()
		if (function_exists('return_i18n_languages')) {
			$languages = return_i18n_languages();
			if (!empty($languages) && is_array($languages)) {
				return strtolower($languages[0]);
			}
		}
		
		// Priority 2: I18N plugin default language
		if (function_exists('return_i18n_default_language')) {
			$defaultLang = return_i18n_default_language();
			if (!empty($defaultLang)) {
				return strtolower($defaultLang);
			}
		}
		
		// Priority 3: Custom global variable
		global $MULTIBLOCK_LANG;
		if (isset($MULTIBLOCK_LANG) && !empty($MULTIBLOCK_LANG)) {
			return strtolower($MULTIBLOCK_LANG);
		}
		
		// Priority 4: GetSimple admin language
		global $LANG;
		if (isset($LANG) && !empty($LANG)) {
			$lang = strtolower($LANG);
			return substr($lang, 0, 2);
		}
		
		return '';
	}
	
	/**
	 * Resolve category name with language support
	 * @param string $category Base category name
	 * @return string Resolved category with language suffix if exists
	 */
	private function resolveCategoryWithLanguage($category) {
		$currentLang = $this->getCurrentLanguage();
		
		if (!empty($currentLang)) {
			$categoryWithLang = $category . '_' . $currentLang;
			$pathWithLang = GSDATAOTHERPATH . 'oneBlock/' . $categoryWithLang;
			
			if (file_exists($pathWithLang) && is_dir($pathWithLang)) {
				return $categoryWithLang;
			}
		}
		
		return $category;
	}
	
	/**
	 * Get JSON file path with language support
	 * @param string $category Category name
	 * @param string $name Block name
	 * @return string Full path to JSON file
	 */
	private function getJsonPath($category, $name) {
		$resolvedCategory = $this->resolveCategoryWithLanguage($category);
		return GSDATAOTHERPATH . 'oneBlock/' . $resolvedCategory . '/' . $name . '.json';
	}
	
	/**
	 * Get and display text value from OneBlock
	 * @param string $category Category name (without language suffix)
	 * @param string $name Block name
	 * @param string $input Field name
	 */
	public function get($category, $name, $input) {
		$value = $this->getJsonPath($category, $name);
		
		if (!file_exists($value)) {
			return;
		}
		
		$files = file_get_contents($value);
		$json = json_decode($files);
		echo $json->$input;
	}

	/**
	 * Get and display WYSIWYG content from OneBlock
	 * @param string $category Category name (without language suffix)
	 * @param string $name Block name
	 * @param string $input Field name
	 */
	public function wysywig($category, $name, $input) {
		$value = $this->getJsonPath($category, $name);
		
		if (!file_exists($value)) {
			return;
		}
		
		$files = file_get_contents($value);
		$json = json_decode($files);
		echo html_entity_decode($json->$input);
	}

	/**
	 * Get and display thumbnail from OneBlock
	 * @param string $category Category name (without language suffix)
	 * @param string $name Block name
	 * @param string $input Field name
	 * @param int $width Thumbnail width
	 */
	public function thumb($category, $name, $input, $width) {
		$value = $this->getJsonPath($category, $name);
		
		if (!file_exists($value)) {
			return;
		}
		
		$files = file_get_contents($value);
		$json = json_decode($files);

		$img = $json->$input;

		global $SITEURL;

		$file = file_get_contents($img);

		$folder = GSDATAOTHERPATH . "multiBlock/thumb/";

		if (file_exists($folder) == null) {
			mkdir($folder, 0755);
			file_put_contents($folder . '.htaccess', 'Allow from all');
		};

		$extension =  pathinfo($img, PATHINFO_EXTENSION);

		$base = pathinfo($img, PATHINFO_BASENAME);

		$finalfile = $folder . $width . "-" . $base;

		if (file_exists($finalfile)) {
		} else {

			$origPic = imagecreatefromstring($file);

			$width_orig = imagesx($origPic);
			$height_orig = imagesy($origPic);

			$height = $height_orig  * 1.77;

			$ratio_orig = $width_orig / $height_orig;

			if ($width / $height > $ratio_orig) {
				$width = $height * $ratio_orig;
			} else {
				$height = $width / $ratio_orig;
			}

			$thumbnail = imagecreatetruecolor($width, $height);

			imagecopyresampled($thumbnail, $origPic, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

			if ($extension == 'jpeg' || $extension == 'jpg') {
				imagejpeg($thumbnail, $finalfile);
			} elseif ($extension == 'png') {
				imagepng($thumbnail, $finalfile);
			} elseif ($extension == 'webp') {
				imagewebp($thumbnail, $finalfile);
			} elseif ($extension == 'gif') {
				imagegif($thumbnail, $finalfile);
			} elseif ($extension == 'bmp') {
				imagebmp($thumbnail, $finalfile);
			} else {
				imagejpeg($thumbnail, $finalfile);
			}

			imagedestroy($origPic);
			imagedestroy($thumbnail);
		};

		echo str_replace(GSDATAOTHERPATH, $SITEURL . 'data/other/', $finalfile);
	}
};