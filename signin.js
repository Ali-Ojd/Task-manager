function valid(){
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let pass = document.getElementById("pass").value;
    let con = document.getElementById("con").value;
    let message = document.getElementById("message");

    if(name === "" || email === "" || pass === "" || con === ""){
        message.innerHTML = "All blocks must be filled!";
        message.style.color = "yellow";
        return false;
    }
    
    if(pass != con){
        message.innerHTML = "The two passwords should match!";
        message.style.color = "yellow";
        return false;
    }
    
    return true;
}