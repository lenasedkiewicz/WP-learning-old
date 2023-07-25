document.addEventListener("DOMContentLoaded", function () {
  // Handle the "All Posts" checkbox
  var allPostsCheckbox = document.getElementById("associated_post_ids_all");
  allPostsCheckbox.addEventListener("change", function () {
    var checkboxes = document.getElementsByName("associated_post_ids[]");
    checkboxes.forEach(function (checkbox) {
      checkbox.checked = allPostsCheckbox.checked ? false : checkbox.checked;
    });
  });

  // Handle individual post checkboxes
  var postCheckboxes = document.getElementsByName("associated_post_ids[]");
  postCheckboxes.forEach(function (checkbox) {
    checkbox.addEventListener("change", function () {
      allPostsCheckbox.checked = false;
    });
  });

  // Handle category selection
  var categorySelect = document.getElementById("associated_category");
  categorySelect.addEventListener("change", function () {
    allPostsCheckbox.checked = false;
    postCheckboxes.forEach(function (checkbox) {
      checkbox.checked = false;
    });
  });
});
document.addEventListener("DOMContentLoaded", function () {
  // Handle the "All Posts" checkbox
  var allPostsCheckbox = document.getElementById("associated_post_ids_all");
  allPostsCheckbox.addEventListener("change", function () {
    var checkboxes = document.getElementsByName("associated_post_ids[]");
    checkboxes.forEach(function (checkbox) {
      checkbox.checked = allPostsCheckbox.checked ? false : checkbox.checked;
    });
  });

  // Handle individual post checkboxes
  var postCheckboxes = document.getElementsByName("associated_post_ids[]");
  postCheckboxes.forEach(function (checkbox) {
    checkbox.addEventListener("change", function () {
      allPostsCheckbox.checked = false;
    });
  });

  // Handle category selection
  var categorySelect = document.getElementById("associated_category");
  categorySelect.addEventListener("change", function () {
    allPostsCheckbox.checked = false;
    postCheckboxes.forEach(function (checkbox) {
      checkbox.checked = false;
    });
  });
});
