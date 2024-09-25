class course{
    constructor(){
        this.divRoot = document.getElementById('root');
    }

    createDiv(){
        let div = document.createElement('div');
        div.setAttribute('id', 'course');
        this.divRoot.appendChild(div);
    }


}

const coursePage = new course();



