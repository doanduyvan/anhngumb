import { mbNotification, mbConfirm, mbLoading, mbFetch } from '../allmodule.js';
const divRoot = document.getElementById('root');
const templateroot = `

    `;
// divRoot.innerHTML = templateroot;


// dùng để số box thêm khóa học
const EaddCourse = document.querySelector('.addCourse');
const btnAddCourse = document.querySelector('.btn-addCourse');
const closeboxaddcourse = document.querySelector('.addCourse-box-btn-close');
btnAddCourse.addEventListener('click', () => {
    EaddCourse.classList.add('show');
});
closeboxaddcourse.addEventListener('click', () => {
    EaddCourse.classList.remove('show');
});

// show các khóa học

const datademo = [
    {
        id: 1,
        courseName: 'anh van v1',
        createdAt: '29/9/24'
    },
    {
        id: 1,
        courseName: 'anh van v2',
        createdAt: '29/9/24'
    },
    {
        id: 1,
        courseName: 'anh van v3',
        createdAt: '29/9/24'
    },
    {
        id: 1,
        courseName: 'anh van v4',
        createdAt: '29/9/24'
    },
    {
        id: 1,
        courseName: 'anh van v5',
        createdAt: '29/9/24'
    }
]


renderCourse(datademo);

function renderCourse(data) {
    const tbdycourse = document.getElementById('tbody-course');
    data.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
                    <td>${item.courseName}</td>
                    <td>${item.createdAt}</td>
                    <td class="td-btn">
                        <button class="btn btn-primary btn-edit-course">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="23" height="23">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                              </svg>
                        </button>
                        <button class="btn btn-danger btn-del-course">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                              </svg>                              
                        </button>
                    </td>
            `;

            const btnedit = tr.querySelector('.btn-edit-course');
            const btndel = tr.querySelector('.btn-del-course');
            btnedit.onclick = function(){
                console.log(item);
                showEditCourse(item);
            }

        tbdycourse.appendChild(tr);
    });

}

function showEditCourse(data){
    
    const box = document.querySelector('.dv-edit-course-container');
    const boxcontent = document.createElement('div');
    boxcontent.classList.add('dv-edit-course');
    boxcontent.innerHTML = `
                <form action="" class="formEdit">
                <div class="fromGroup">
                    <label for="" class="formLabel">Nhập tên khóa học</label>
                    <input type="text" value="${data.id}" name="id" hidden>
                    <input type="text" value="${data.courseName}" name="courseName" class="formInput" placeholder="">
                </div>
                <button class="btn btn-primary">Accept</button>
            </form>
    `;

    const formEdit = boxcontent.querySelector('.formEdit');
    boxcontent.onclick = function(e){
        if(!formEdit.contains(e.target)){
            boxcontent.remove();
        }
    }

    box.appendChild(boxcontent);
}



const addCourseform = document.querySelector('.addCourse-form');
addCourseform.addEventListener('submit', async function (e) {
    e.preventDefault();

    const check = await mbConfirm('ok khong')
    console.log('ok: ', check);

});






// test
async function test3() {

    try {
        mbLoading(true);
        const data = await mbFetch('admin/courses/test2/1');
        render123(data);
    } catch (err) {
        console.log('err', err);
    }finally{
        console.log('done');
        mbLoading(false);
    }

}


function render123(data) {
    // render
    console.log('data dong 176', data);
}

function laydulieutusever() {
    return new Promise(function (rosolve, reject) {
        setTimeout(() => {
            const data = [
                {
                    id: 1,
                    name: 'hhi'
                }
            ];
            // reject(data);

        }, 5000);

    });

}