<?php

class frontMultiBlock {

	/**
	 * Get current site language with I18N plugin support
	 * Based on I18N plugin documentation: http://mvlcek.bplaced.net/get-simple/i18n:en
	 * @return string Language code (e.g., 'pl', 'en', 'de')
	 */
	private function getCurrentLanguage() {
		// Priority 1: I18N plugin - return_i18n_languages()
		// Returns array of user requested languages, we take the first (best match)
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
		
		// Priority 3: Custom global variable (manual override)
		global $MULTIBLOCK_LANG;
		if (isset($MULTIBLOCK_LANG) && !empty($MULTIBLOCK_LANG)) {
			return strtolower($MULTIBLOCK_LANG);
		}
		
		// Priority 4: GetSimple admin language (fallback)
		global $LANG;
		if (isset($LANG) && !empty($LANG)) {
			// GetSimple may return 'en_US', take first 2 characters
			$lang = strtolower($LANG);
			return substr($lang, 0, 2);
		}
		
		// No language detected - use default category without suffix
		return '';
	}

	/**
	 * Resolve category name with language support
	 * @param string $category Base category name (without language suffix)
	 * @return string Resolved category name with language suffix if exists, otherwise original
	 */
	private function resolveCategoryWithLanguage($category) {
		$currentLang = $this->getCurrentLanguage();
		
		// Only check for language suffix if language is detected
		if (!empty($currentLang)) {
			// Check if category with language suffix exists
			$categoryWithLang = $category . '_' . $currentLang;
			$pathWithLang = GSDATAOTHERPATH . 'multiBlock/' . $categoryWithLang;
			
			if (file_exists($pathWithLang) && is_dir($pathWithLang)) {
				return $categoryWithLang;
			}
		}
		
		// Fallback to original category without language suffix
		return $category;
	}

	/**
	 * Get and display multiblock category with I18N support
	 * @param string $category Category name (without language suffix)
	 * @param string $orderid Optional CSS selector for custom ordering
	 */
	public function get($category, $orderid = '') {
		global $getmb;
		
		// Resolve category with language support
		$resolvedCategory = $this->resolveCategoryWithLanguage($category);
		$categoryPath = GSDATAOTHERPATH . 'multiBlock/' . $resolvedCategory;
		
		// Check if category exists
		if (!file_exists($categoryPath) || !is_dir($categoryPath)) {
			return;
		}
		
		// Get order file
		$orderFile = $categoryPath . '/order.txt';
		$orders = @file_get_contents($orderFile);
		
		// Process all JSON blocks in category
		foreach (glob($categoryPath . "/*.json") as $mbBlock) {
			$info = pathinfo($mbBlock);
			$name = basename($mbBlock, '.' . $info['extension']);
			
			// Template path uses original category (without language suffix)
			$template = GSDATAOTHERPATH . 'multiBlock/category/' . $category . '.txt';
			
			// Load JSON data
			$mbjson = file_get_contents($mbBlock);
			$getmb = json_decode($mbjson);
			
			// Include template if exists
			if (file_exists($template)) {
				include($template);
			}
		}
		
		// Apply custom order if orderid is provided
		if ($orderid !== '') {
			$sanitizedCategory = str_replace(['-', '_'], '', $resolvedCategory);
			
			echo "\n<script>\n";
			echo "const arraylist" . $sanitizedCategory . " = '" . $orders . "';\n";
			echo "const arraychange" . $sanitizedCategory . " = arraylist" . $sanitizedCategory . ".split(',');\n";
			echo "arraylist" . $sanitizedCategory . ".split(',').forEach((x,i)=>{\n";
			echo "	if(document.querySelector(`" . $orderid . " [data-id='\${x}']`) !== null){\n";
			echo "		document.querySelector('" . $orderid . "').append(document.querySelector(`" . $orderid . " [data-id='\${x}']`));\n";
			echo "	}\n";
			echo "});\n";
			echo "</script>\n";
			
			global $counterOrder;
			$counterOrder = 0;
		}
	}
	
	/**
	 * Get current detected language (useful for debugging)
	 * @return string Current language code or empty string
	 */
	public function getCurrentLang() {
		return $this->getCurrentLanguage();
	}
	
	/**
	 * Get all available languages for debugging
	 * @return array Array of available languages
	 */
	public function getAvailableLanguages() {
		if (function_exists('return_i18n_available_languages')) {
			return return_i18n_available_languages();
		}
		return array();
	}
}