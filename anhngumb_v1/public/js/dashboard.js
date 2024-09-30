const divRoot = document.getElementById('root');
function baselayout(){
    return `
           <div class="content">
                            <h3 id="message" style="color: red"></h3>
                            <div class="addCourse show">
                                <button class="btn btn-primary btn-addCourse">Add Course</button>
                                <div class="addCourse-box">
                                    <form action="" id="courseForm" class="addCourse-form">
                                        <div class="fromGroup">
                                            <label for="courseName" class="formLabel">Course Name</label>
                                            <input type="text" id="courseName" name="courseName" class="formInput" placeholder="Enter course name">
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </form>
                                    <button class="addCourse-box-btn-close">⬆️</button>
                                </div>
                            </div>

                            <div class="listCourse">
                                <h3 class="listCourse-title">List Course</h3>
                                <table class="table-course">
                                    <thead>
                                        <tr>
                                            <th>Course Name</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="content-course">

                                    </tbody>
                                </table>
                                <div class="listCourse-pagination">
                                    <ul class="listCourse-pagination-ul">
                                        <li><a href="">1</a></li>
                                        <li><a href="">2</a></li>
                                        <li><a href="">3</a></li>
                                    </ul>
                                </div>
                            </div>


                        </div> 
                        
                     </div>
                </main>
            </div>
        </div>


         <div class="course-overllay-edit">
            <div class="course-overllay-edit-box">
                <form action="" class="formEdit">
                    <div class="fromGroup">
                        <label for="courseName" class="formLabel">Course Name</label>
                        <input type="text" id="courseName" name="courseName" class="formInput" placeholder="Enter course name" value="level 1">
                    </div>
                    <div class="btn-submit">
                        <button class="btn btn-primary">Update</button>
                    </div>
                    <div class="btn-close">❌</div>
                </form>
            </div>
        </div> 

         <div class="course-overllay-del">
            <div class="course-overllay-del-box">
                <div class="formDel">
                    <p class="course-overllay-del-box-title">Are you sure you want to delete this course?</p>
                    <div class="btn-group">
                        <button class="btn btn-primary">Yes</button>
                        <button class="btn btn-danger">No</button>
                    </div>
                </div>
            </div>
        </div>
    `;
}
divRoot.innerHTML = baselayout();






document.addEventListener('DOMContentLoaded', function() {
    fetch('admin/dashboard/getcourses')
    .then(response => response.json())
    .then(data => {
        const contentcourse = document.getElementById('content-course');
        contentcourse.innerHTML = '';

        data.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${item.courseName}</td>
            <td>${item.createdAt}</td>
            <td>
                <div class="actions">
                    <button class="btn btn-primary">Edit</button>
                    <button class="btn btn-danger">Delete</button>
                </div>
            </td>
        `;
        contentcourse.appendChild(tr);
    });
    })
    .catch(error => console.error('Error:', error));
});



document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('courseForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Ngăn chặn việc gửi form mặc định

        const formData = new FormData(form);

        // Gửi yêu cầu AJAX
        fetch('admin/dashboard/addcourse', {
            method: 'POST',
            body: new URLSearchParams(formData),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Thêm khóa học mới vào bảng mà không tải lại trang
                const contentcourse = document.getElementById('content-course');
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${data.course.courseName}</td>
                    <td>${data.course.createdAt}</td>
                    <td>
                        <div class="actions">
                            <button class="btn btn-primary">Edit</button>
                            <button class="btn btn-danger">Delete</button>
                        </div>
                    </td>
                `;
                // Kiểm tra số lượng dòng hiện có trong bảng
                const rows = contentcourse.getElementsByTagName('tr');
                if (rows.length >= 5) {
                    contentcourse.removeChild(rows[rows.length - 1]);
                }
                contentcourse.insertBefore(tr, contentcourse.firstChild);
                document.getElementById('courseName').value = '';
            }else {
                console.error('Error:', data.message);
            }
            
        })
            .catch(error => console.error('Error:', error));
        });
});



