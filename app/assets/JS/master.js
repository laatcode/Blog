try {
  let $fileChoosen = document.querySelector('[type=file]')
  let $labelFileChoosen = document.querySelector('.custom-file-label').firstChild
  let $imagePreview = document.querySelector('#profileImage')

  $fileChoosen.addEventListener('change', updateImgLabel);

  function updateImgLabel() {
    if ($fileChoosen.files[0]) {
      $labelFileChoosen.textContent = $fileChoosen.files[0].name
      $imagePreview.src = window.URL.createObjectURL($fileChoosen.files[0])
    }
  }
} catch (e) {

}
