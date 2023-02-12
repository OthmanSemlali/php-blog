// Sub-categories JS (for handle the dropdowns )
const categories = document.querySelector("#categories");
const categoryLis = categories.querySelectorAll("li");
categoryLis.forEach(function (li) {
  const subcategories = li.querySelector(".subcategories");
  const icon = li.querySelector(".fa");

  if (subcategories) {
    li.addEventListener("click", function (event) {
      // Hide any open subcategories
      const openSubcategories = categories.querySelectorAll(
        ".subcategories:not(.hidden)"
      );
      subcategories.classList.add("hover");

      openSubcategories.forEach(function (el) {
        el.classList.add("hidden");
      });

      // Toggle the clicked subcategory
      subcategories.classList.toggle("hidden");
      // icon.classList.toggle('fa-caret-down');
      // icon.classList.toggle('fa-caret-up');
    });
  }
});
