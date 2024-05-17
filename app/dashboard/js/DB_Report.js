const find_date_report = document.getElementById("find_date_report");
const add_report_btn = document.getElementById("add_report_btn");
const reset_report_btn = document.getElementById("reset_date_report");
const date = document.getElementById("date");


find_date_report.onclick = () => {

  if (date.value.trim() === "") {

    alert("Bạn phải chọn ngày lập báo cáo!")

  } else {
    window.location.href = `./DB_Report.php?action=search_date&date=${date.value.trim()}`;
  }
}

add_report_btn.onclick = () => {
  if (confirm("Bạn có chắc muốn tạo report ?") == true) {
    window.location.href = `./DB_Report.php?action=add-report`;
  } else {

  }

}

const currentUrl = new URL(window.location.href);

if (currentUrl.searchParams.get("action") === "search_date" && currentUrl.searchParams.get("date").trim() !== "") {
  date.value = currentUrl.searchParams.get("date").split(" ")[0];
} else {
  reset_report_btn.classList.add('disable_hover_btn');
  reset_report_btn.disabled = true;
}

reset_report_btn.onclick = () => {
  window.location.href = `./DB_Report.php`;
}