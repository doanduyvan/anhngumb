import {
  mbNotification,
  mbConfirm,
  mbLoading,
  mbFetch,
  mbPagination,
  mbFormData,
} from "../allmodule.js";

// dùng để hiển thị ra template trước khi gọi tới DOM
const divRoot = document.getElementById("root");
const templateroot = `
    <div class="dv-content">
        <div class="addClass">
            <button class="btn btn-primary btn-addClass">Add Lesson</button>
            <div class="addClass-box">
                <form action="" class="addClass-form">
        <div class="fromGroup">
            <label for="className" class="formLabel">Lesson Name</label>
            <input type="text" id="className" name="className" class="formInput" placeholder="Enter lesson name">
        </div>
        <div class="fromGroup">
            <label for="courseId" class="formLabel">Courses ID</label>
            <select id="courseId" name="courseId" class="formInput">
                <option value="">Select Course ID</option>
            </select>
        </div>
        <div class="fromGroup">
            <label for="startDate" class="formLabel">Star Date</label>
            <input type="date" name="startDate" id="startDate" class="formInput">
        </div>
        <div>
            <button class="btn btn-primary">Add</button>
        </div>
    </form>
                <button class="addClass-box-btn-close">⬆️</button>
            </div>
        </div>
        <div class="list-Class">
            <h3 class="list-Class-title">List Lesson</h3>
            <div class="course-search">
                <div class="course-search-box"></div>
            </div>
            <table class="table-class">
                <thead>
                    <tr>
                        <th>Lesson Name</th>
                        <th>Star Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tbody-class"></tbody>
            </table>
            <div class="list-class-pagination-container">
                <div class="list-class-pagination-container-select">
                    <select name="" id="">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                </div>
                <div class="list-class-pagination"></div>
            </div>
        </div>
        </div>
    </div>
    <div class="dv-edit-class-container"></div>
        `;
divRoot.innerHTML = templateroot;

// dùng để số box thêm khóa học
const EaddClass = document.querySelector(".addClass");
const btnaddClass = document.querySelector(".btn-addClass");
const closeboxaddClass = document.querySelector(".addClass-box-btn-close");
btnaddClass.addEventListener("click", () => {
  EaddClass.classList.add("show");
});
closeboxaddClass.addEventListener("click", () => {
  EaddClass.classList.remove("show");
});

let coursesGlobal = [];

const classObject = {
  currentPage: 1,
  totalPage: null,
  itemPerPage: 5,
};
const handlerProxyCourse = {
  set(target, property, value) {
    target[property] = value;
    // Nếu người dùng thay đổi trang
    if (property === "currentPage") {
      renderLesson();
    } else if (property === "itemPerPage") {
      renderLesson();
    }
    return true;
  },
};
const proxyCourse = new Proxy(classObject, handlerProxyCourse);

proxyCourse.currentPage = 1;

async function renderLesson() {
  const EliscourtLoading = document.querySelector(".dv-content .list-Class");
  mbLoading(true, EliscourtLoading);
  const url =
    "admin/classes/getclasses/" +
    classObject.currentPage +
    "/" +
    classObject.itemPerPage;
  let datares = [];
  try {
    datares = await mbFetch(url);
  } catch (err) {
    console.log(err);
    return;
  } finally {
    mbLoading(false, EliscourtLoading);
  }

  proxyCourse.totalPage = datares.totalPages;
  const data = datares.Classes;

  const tbdyclass = document.createElement("tbody");
  tbdyclass.id = "tbody-class";
  data.forEach((item) => {
    console.log(item);
    const tr = itemtr(item);
    tbdyclass.appendChild(tr);
  });

  const tbodyold = document.getElementById("tbody-class");
  tbodyold.replaceWith(tbdyclass);

  // render pagination
  const paginationBox = document.querySelector(".list-class-pagination");
  const paginationUl = mbPagination(
    classObject.currentPage,
    classObject.totalPage
  );
  if (paginationBox.firstChild) {
    paginationBox.removeChild(paginationBox.firstChild);
  }
  paginationBox.appendChild(paginationUl);
  [...paginationBox.querySelectorAll("a")].forEach((item) => {
    item.addEventListener("click", function (e) {
      e.preventDefault();
      const page = parseInt(this.dataset.page);
      proxyCourse.currentPage = page;
    });
  });
}

// component item tr

function itemtr(item) {
  const tr = document.createElement("tr");
  // hàm định dạng ngày từ yyyy-mm-dd sang dd-mm-yyyy
  function formatDate(dateString) {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, "0");
    const month = String(date.getMonth() + 1).padStart(2, "0"); // Tháng bắt đầu từ 0
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
  }
  // Sử dụng hàm formatDate để định dạng ngày
  const formattedStartDate = formatDate(item.startDate);
  const formattedEndDate = formatDate(item.endDate);
  tr.innerHTML = `
                  <td>${item.className}</td>
                  <td>${formattedStartDate}</td>
                  <td>${formattedEndDate}</td>
                  <td class="td-btn">
                      <button class="btn btn-primary btn-edit-class">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="23" height="23">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                      </button>
                      <button class="btn btn-danger btn-del-class">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>                              
                      </button>
                  </td>
          `;
  const btnedit = tr.querySelector(".btn-edit-class");
  const btndel = tr.querySelector(".btn-del-class");
  btnedit.onclick = async function () {
    const data = await showFormEditClass(item);
    if (data) {
      const newtr = itemtr(data);
      tr.replaceWith(newtr);
    }
  };
  btndel.onclick = async function () {
    const confirm = await mbConfirm(
      `You definitely want to delete lesson <span style="color: blue"> ${item.className} </span>?`
    );
    if (!confirm) {
      return;
    }
    const check = await removeClass(item);
    if (check) {
      tr.remove();
    }
  };
  return tr;
}

// sửa khóa học
function showFormEditClass(data) {
  return new Promise((resolve) => {
    const box = document.querySelector(".dv-edit-class-container");
    const boxcontent = document.createElement("div");
    boxcontent.classList.add("dv-edit-class");
    boxcontent.innerHTML = `
                    <form action="" class="formEdit">
                    <div class="fromGroup">
                        <label for="" class="formLabel">Nhập tên khóa học</label>
                        <input type="text" value="${data.id}" name="id" hidden>
                        <input type="text" value="${data.className}" name="className" class="formInput" placeholder="">
                    </div>
                    <button class="btn btn-primary">Accept</button>
                </form>
        `;
    const formEdit = boxcontent.querySelector(".formEdit");
    boxcontent.onclick = function (e) {
      if (!formEdit.contains(e.target)) {
        boxcontent.remove();
        resolve(null);
      }
    };
    formEdit.onsubmit = async function (e) {
      e.preventDefault();
      const formData = mbFormData(formEdit);
      if (formData.className === "") {
        mbNotification("Error", "Please enter course name", 3);
        return;
      }
      const urledit = "admin/classes/editClass";
      const data = await mbFetch(urledit, formData);
      boxcontent.remove();
      if (data.error) {
        console.log(data.error);
        mbNotification("Error", data.error, 2, 2);
        resolve(null);
      } else {
        mbNotification("Success", "Edit success", 1, 2);
        resolve(data);
      }
    };
    box.appendChild(boxcontent);
  });
}

// xóa Lớp học

async function removeClass(Class) {
  return new Promise(async (resolve) => {
    const url = "admin/classes/deleteClass";
    const datareq = { id: Class.id };
    try {
      const datares = await mbFetch(url, datareq);
      if (datares.error) {
        console.log(datares.error);
        resolve(false);
      } else {
        resolve(true);
        mbNotification("Success", "Delete success", 1, 2);
      }
    } catch (err) {
      console.log(err);
      resolve(false);
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
  const addClassForm = document.querySelector(".addClass-form");
  const EaddClass = document.querySelector(".addClass");
  const btnaddClass = document.querySelector(".btn-addClass");
  const closeboxaddClass = document.querySelector(".addClass-box-btn-close");

  btnaddClass.addEventListener("click", () => {
    EaddClass.classList.add("show");
  });

  closeboxaddClass.addEventListener("click", () => {
    EaddClass.classList.remove("show");
  });

  async function fetchCourses() {
    const url = "admin/courses/getallcourses";
    try {
      const courses = await mbFetch(url);
      // console.log("ghi chu 229: ",courses);
      coursesGlobal = courses;
      const courseSelect = document.getElementById("courseId");

      courses.forEach((course) => {
        const option = document.createElement("option");
        option.value = course.id;
        option.textContent = course.courseName;
        courseSelect.appendChild(option);
      });
    } catch (err) {
      console.error("Error fetching courses:", err);
    }
  }

  fetchCourses();

  addClassForm.addEventListener("submit", async function (e) {
    e.preventDefault();
    const formData = {
      courseId: document.getElementById("courseId").value,
      className: document.getElementById("className").value,
      startDate: document.getElementById("startDate").value,
    };
    console.log(formData.startDate);
    if (!formData.courseId || !formData.className || !formData.startDate) {
      mbNotification("Error", "Please enter all required fields", 3);
      return;
    }

    const url = "admin/classes/addClass";
    try {
      const data = await mbFetch(url, formData);
      console.log(data);

      if (data.error) {
        console.log(data.error);
        mbNotification("Error", data.error, 2, 2);
      } else {
        const tbody = document.getElementById("tbody-class");
        if (!tbody) {
          console.error("Element #tbody-class không tồn tại.");
          return;
        }
        const newtr = itemtr(data);

        if (tbody.firstChild) {
          tbody.insertBefore(newtr, tbody.firstChild);
        } else {
          tbody.appendChild(newtr);
        }
        mbNotification("Success", "Add lesson success", 1, 2);
        addClassForm.reset();
      }
    } catch (err) {
      console.log(err);
      mbNotification("Error", "An error occurred while adding the lesson", 3);
    } finally {
      EaddClass.classList.remove("show");
    }
  });
});

const selectItemPerPage = document.querySelector(
  ".list-class-pagination-container-select select"
);
selectItemPerPage.addEventListener("change", function () {
  proxyCourse.itemPerPage = parseInt(this.value);
});
