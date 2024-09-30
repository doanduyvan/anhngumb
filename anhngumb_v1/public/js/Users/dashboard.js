


const divRoot = document.getElementById('root');
function baselayout(){
    return `
           <div class="content">
                            <div class="addCourse show">
                                <button class="btn btn-primary btn-addCourse">Add Course</button>
                                <div class="addCourse-box">
                                    <form action="" class="addCourse-form">
                                        <div class="fromGroup">
                                            <label for="courseName" class="formLabel">Course Name</label>
                                            <input type="text" id="courseName" name="courseName" class="formInput" placeholder="Enter course name">
                                        </div>
                                        <div>
                                            <button class="btn btn-primary">Add</button>
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




const courses = [
    {
        id: 1,
        courseName: 'Course 1',
        createdAt: '2021-09-09'
    },
    {
        id: 2,
        courseName: 'Course 2',
        createdAt: '2021-09-09'
    },
    {
        id: 3,
        courseName: 'Course 3',
        createdAt: '2021-09-09'
    }
];

function getCourse(){
 return courses;
}


function renderCourse(courses = []){
    const contentcourse = document.getElementById('content-course');
    contentcourse.innerHTML = '';

    courses.forEach(item => {
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
}

renderCourse(getCourse());


const addCourseForm = document.querySelector('.addCourse-form');
addCourseForm.addEventListener('submit', function(e){
    e.preventDefault();
    const formData = new FormData(addCourseForm);
    const courseName = formData.get('courseName');
    // addCourse(courseName);
    getcourse();
});



function addCourse(courseName){
    $options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({courseName})
    };

    fetch('', $options)
}


function getcourse(){
    fetch('admin/dashboard/getcourse')
    .then(res => res.json())
    .then(data => {
        console.log(data);
    })
}











