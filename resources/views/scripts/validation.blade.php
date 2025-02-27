requiredFields.forEach(field => {
  $(`#${field.id}`).on(field.event, function () {
    validateField($(this), field.isSelect);
  });
});

function validateField($element, isSelect = false) {
  const feedbackElement = `#${$element.attr('id')}-feedback`;
  let value = $element.val();

  if (isSelect) {
    value = $element.val() && $element.val() !== "";
  } else {
    value = value.trim();
  }

  if (value) {
    if (isSelect) {
      $element.next('span').removeClass('is-invalid');
    } else {
      $element.removeClass('is-invalid');
    }
    $(feedbackElement).html('');
  } else {
    if (isSelect) {
      $element.next('span').addClass('is-invalid');
    } else {
      $element.addClass('is-invalid');
    }
  }
}