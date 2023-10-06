class Signup{
    constructor(email, pass, article, submitBtn){
        this.email = email;
        this.pass = pass;
        this.article = article;
        console.log(submitBtn)
        submitBtn.onclick = this.submit;

    }
    submit = () =>{
        if(this.email.value != "" && this.pass.value != ""){
            fetch("http://localhost:8080/api/api.php",
            {
                mode: 'no-cors',
                headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
                },
                method: "POST",
                body: JSON.stringify({"email":this.email.value, 'pass':this.pass.value, 'article':this.article.value})
            })
            .then(function(res){ console.log(res) })
            .catch(function(res){ console.log(res) })
            return
        }
        console.log("error")
    }
}

let signup = new Signup(document.getElementById('email'), document.getElementById('pass'),document.getElementById('article'),document.getElementById('submitBtn'),)