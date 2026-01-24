<script>
	if (document.querySelector('#categoryname') !== null) {

		document.querySelector('#categoryname').style.display = "none";
	};
</script>



<script>
	document.addEventListener('DOMContentLoaded', function() {



			const nameTitleInput = document.querySelector('.nametitle');
			const categorySlugInput = document.querySelector('.namefile');

			if ( nameTitleInput !== null) {

				categorySlugInput.style.display="none";

				nameTitleInput.addEventListener('input', function() {
					const inputValue = this.value.trim();
					const slugValue = removeSpecialCharacters(inputValue);
					categorySlugInput.value = slugValue;
				});

				function removeSpecialCharacters(str) {
					const accentsMap = {
						'á': 'a',
						'é': 'e',
						'í': 'i',
						'ó': 'o',
						'ú': 'u',
						'à': 'a',
						'è': 'e',
						'ì': 'i',
						'ò': 'o',
						'ù': 'u',
						'â': 'a',
						'ê': 'e',
						'î': 'i',
						'ô': 'o',
						'û': 'u',
						'ä': 'a',
						'ë': 'e',
						'ï': 'i',
						'ö': 'o',
						'ü': 'u',
						'ã': 'a',
						'õ': 'o',
						'ñ': 'n',
						'ç': 'c',
						'ā': 'a',
						'ē': 'e',
						'ī': 'i',
						'ō': 'o',
						'ū': 'u',
						'ă': 'a',
						'ĕ': 'e',
						'ĭ': 'i',
						'ŏ': 'o',
						'ŭ': 'u',
						'ą': 'a',
						'ę': 'e',
						'į': 'i',
						'ų': 'u',
						'đ': 'd',
						'ı': 'i',
						'ß': 'ss',
						'Þ': 'th',
						'þ': 'th',
						'Ð': 'dh',
						'ð': 'dh'
					};

					return str.replace(/[^\w\s]/gi, function(match) {
						return accentsMap[match] || match;
					}).replace(/\s+/g, '').toLowerCase();
				}
			}
		}

	);
</script>


<script>
	document.addEventListener('DOMContentLoaded', function() {



			const categoryTitleInput = document.getElementById('categorytitle');
			const categorySlugInput = document.getElementById('categoryname');

			if (categoryTitleInput !== null) {

				categoryTitleInput.addEventListener('input', function() {
					const inputValue = this.value.trim();
					const slugValue = removeSpecialCharacters(inputValue);
					categorySlugInput.value = slugValue;
				});

				function removeSpecialCharacters(str) {
					const accentsMap = {
						'á': 'a',
						'é': 'e',
						'í': 'i',
						'ó': 'o',
						'ú': 'u',
						'à': 'a',
						'è': 'e',
						'ì': 'i',
						'ò': 'o',
						'ù': 'u',
						'â': 'a',
						'ê': 'e',
						'î': 'i',
						'ô': 'o',
						'û': 'u',
						'ä': 'a',
						'ë': 'e',
						'ï': 'i',
						'ö': 'o',
						'ü': 'u',
						'ã': 'a',
						'õ': 'o',
						'ñ': 'n',
						'ç': 'c',
						'ā': 'a',
						'ē': 'e',
						'ī': 'i',
						'ō': 'o',
						'ū': 'u',
						'ă': 'a',
						'ĕ': 'e',
						'ĭ': 'i',
						'ŏ': 'o',
						'ŭ': 'u',
						'ą': 'a',
						'ę': 'e',
						'į': 'i',
						'ų': 'u',
						'đ': 'd',
						'ı': 'i',
						'ß': 'ss',
						'Þ': 'th',
						'þ': 'th',
						'Ð': 'dh',
						'ð': 'dh'
					};

					return str.replace(/[^\w\s]/gi, function(match) {
						return accentsMap[match] || match;
					}).replace(/\s+/g, '').toLowerCase();
				}
			}
		}

	);
</script>