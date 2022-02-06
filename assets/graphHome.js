import "./styles/admin/graphHome.css";
//onglet
Date.prototype.getWeek = function () {
  var onejan = new Date(this.getFullYear(), 0, 4);
  return Math.ceil(((this - onejan) / 86400000 + onejan.getDay() + 1) / 7);
};
let dateObj = new Date();
const weekNumber = new Date().getWeek();
const year = dateObj.getFullYear();
const month = dateObj.getMonth() + 1;

let addNecessaryZero = function (number) {
  if (number < 10) {
    return "0" + number;
  }
  return number;
};

const inputYear = `<input type="number" onchange="onChangeYear(this)" value="${year}" min="2022" max="${year}" step="1" />`;
const inputMonth = `<input onchange="onChangeMonth(this)" value="${year}-${addNecessaryZero(
  month
)}" type="month" id="start" name="start" min="2022-01" max="${year}-${addNecessaryZero(
  month
)}" >`;
const inputWeek = `<input type="week" onchange="onChangeWeek(this)" id="start" name="start" min="2022-W05"  value="${year}-W${addNecessaryZero(
  weekNumber
)}"  max="${year}-W${addNecessaryZero(weekNumber)}" > `;

let onglets = document.querySelectorAll(".ongletDate");
onglets.forEach((element) => {
  element.addEventListener("click", () => {
    if (!element.classList.contains("active")) {
      removeActiveOnglet();
      element.classList.add("active");
    }
  });
});
let removeActiveOnglet = function () {
  onglets.forEach((element) => {
    if (element.classList.contains("active")) {
      element.classList.remove("active");
    }
  });
};

document.querySelector("#year").addEventListener("click", () => {
  changeToTheYear();
});
document.querySelector("#month").addEventListener("click", () => {
  changeToTheMonth();
});

document.querySelector("#week").addEventListener("click", () => {
  changeToTheWeek();
});

let changeToTheYear = function () {
  let calendar = document.querySelector(".calendar");
  calendar.innerHTML = inputYear;
  changeTheGraphYear(year);
};
let changeToTheMonth = function () {
  let calendar = document.querySelector(".calendar");
  calendar.innerHTML = inputMonth;
  changeTheGraphMonth(year, month);
};
let changeToTheWeek = function () {
  let calendar = document.querySelector(".calendar");
  calendar.innerHTML = inputWeek;
  changeTheGraphWeek(weekNumber, year);
};
let changeTheGraphYear = function (aYear) {
  axios
    .post("/admin/yearlyStat", aYear)
    .then((response) => {
      loadTheGraph(response.data["graph"], "mois");
      console.log(response.data);
    })
    .catch((err) => {
      console.log(err);
    });
};
let changeTheGraphMonth = function (aYear, aMonth) {
  let dateUse = new Object();
  dateUse["year"] = aYear;
  dateUse["month"] = aMonth;
  console.log(dateUse);
  axios
    .post("/admin/monthlyStat", dateUse)
    .then((response) => {
      loadTheGraph(response.data["graph"], "jours");
    })
    .catch((err) => {
      console.log(err);
    });
};
let changeTheGraphWeek = function (aWeek, aYear) {
  let dateUse = new Object();
  dateUse["year"] = aYear;
  dateUse["week"] = aWeek;

  axios
    .post("/admin/weeklyStat", dateUse)
    .then((response) => {
      loadTheGraph(response.data["graph"], "jours");
    })
    .catch((err) => {
      console.log(err);
    });
};
changeTheGraphYear(year);
//graphique
let loadTheGraph = function (arrayGraph, legend) {
  google.charts.load("current", { packages: ["corechart", "line"] });
  google.charts.setOnLoadCallback(drawBasic);

  function drawBasic() {
    var data = new google.visualization.DataTable();
    data.addColumn("string", "Date");
    data.addColumn("number", "Vues");
    arrayGraph.forEach((element) => {
      console.log(element[0]);
      console.log(element[1]);
      data.addRow([element[0], parseInt(element[1])]);
    });

    var options = {
      hAxis: {
        title: legend,
      },
      vAxis: {
        title: "Vues",
      },
    };

    var chart = new google.visualization.LineChart(
      document.getElementById("chart_div")
    );

    chart.draw(data, options);
  }
};
let onChangeYear = function (element) {
  aYear = parseInt(element.value);
  changeTheGraphYear(aYear);
};
let onChangeMonth = function (element) {
  let arrayValue = element.value.split("-");
  changeTheGraphMonth(parseInt(arrayValue[0]), parseInt(arrayValue[1]));
};
let onChangeWeek = function (element) {
  let arrayValue = element.value.split("-");
  changeTheGraphWeek(
    parseInt(arrayValue[1].replace("W", "")),
    parseInt(arrayValue[0])
  );
};

window.onChangeYear = onChangeYear;
window.onChangeMonth = onChangeMonth;
window.onChangeWeek = onChangeWeek;
