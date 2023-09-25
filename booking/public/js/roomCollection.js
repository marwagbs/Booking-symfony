
const formContainer = document.getElementById("formContainer");
const template = formContainer.dataset.template;
const roomBedsList = document.getElementById("roomBedsList");

const addButton = document.getElementById("addButton");
const roomCollection = document.getElementById("roomCollection");
const removeButtons=document.querySelectorAll(".removeBed");


function onClickRemove(){
    this.parentElement.remove();
}

addButton.addEventListener('click', function() {
    const div = document.createElement("div");
    div.innerHTML=template.replace(
        /__name__/g,
        formContainer.dataset.index
    );
    roomCollection.append(div)

    div.querySelector(".removeBed").addEventListener("click", onClickRemove);
    formContainer.dataset.index++;
 })

for(const removeButton of removeButtons){
    removeButton.addEventListener("click", onClickRemove)
}