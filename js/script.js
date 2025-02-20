document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("multiplayerBtn")
    .addEventListener("click", function (e) {
      e.preventDefault();
      document.getElementById("extraButtons").classList.toggle("show");
    });
  const leaderboardList = document.getElementById("leaderboardList");
  document.getElementById("scrollUp").addEventListener("click", function (e) {
    e.preventDefault();
    leaderboardList.scrollBy({ top: -50, behavior: "smooth" });
  });
  document.getElementById("scrollDown").addEventListener("click", function (e) {
    e.preventDefault();
    leaderboardList.scrollBy({ top: 50, behavior: "smooth" });
  });
});
