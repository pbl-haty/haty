window.addEventListener('pageshow', () => {
  if (window.performance.navigation.type == 2) location.reload();
});

// $("#button").on("click", function () {
//   $("#appear").fadeIn("slow");
// });
