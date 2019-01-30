try {
  let $fileChoosen = document.querySelector('[type=file]')
  let $labelFileChoosen = document.querySelector('.custom-file-label').firstChild

  $fileChoosen.addEventListener('change', updateImgLabel);

  function updateImgLabel() {
    if ($fileChoosen.files[0]) {
      $labelFileChoosen.textContent = $fileChoosen.files[0].name
    }
  }
} catch (e) {

}
