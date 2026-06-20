function validation(){
    let email = document.getElementById("email").value;
    let pass = document.getElementById("pass").value;
    let message = document.getElementById("message");

    if(email == "" || pass == ""){
        message.innerHTML = "All blocks should be filled!";
        message.style.color = "Yellow";
        return false;
    }

    return true;
}