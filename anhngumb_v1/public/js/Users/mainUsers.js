import { mbNotification, mbConfirm, mbLoading, mbFetch } from '../allmodule.js';


async function test(){
    mbLoading(true);
    const check = await mbConfirm('Hieu co chap nhan khong?');
    if(check){
        console.log('Hieu da chap nhan');
    }else{
        console.log('Hieu da tu choi');
    }
    mbLoading(false);
}



async function getData(){
    try{
        mbLoading(true);
        const data = await mbFetch('dashboard/getDashboardData');
        mbLoading(false);
        console.log(data);
    }catch(err){
        console.log(err);
    }finally{
        mbLoading(false);
    }
}



const divRoot = document.getElementById('root');

function renderdata(data){
    const divTemp = document.createElement('div');
    divTemp.innerHTML = `

    <style>
        #root{
            padding: 10px;
        }
        #root>div{
            margin-top: 10px;
            background-color: white;
            border-radius: 5px;
        }
        .myh1{
            color: red;
            padding: 10px 3px;
        }
        .div2 table{
            /* border-collapse: collapse; */
            border: 1px solid black;
            width: 100%;
        }
    </style>
    <div class="div1">
        <h1 class="myh1">day la noi dung</h1>
    </div>

    <div class="div2">
        <table>
            <thead>
                <th>id</th>
                <th>name</th>
                <th>age</th>
            </thead>
        </table>
    </div>

    `;
    divRoot.appendChild(divTemp);
}

renderdata(null);