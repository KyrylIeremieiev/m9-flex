class App{

    constructor(title, p){
        this.title = title;
        this.p = p
        this.user = this.getCookie("user");
        if(this.user == null){
            /* window.location.replace('./signup.html') */
        }
            this.getData()
    }
    getCookie(cookieName) {
        var name = cookieName + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var cookieArray = decodedCookie.split(';');
        for (var i = 0; i < cookieArray.length; i++) {
            var cookie = cookieArray[i].trim();
            if (cookie.indexOf(name) === 0) {
                return cookie.substring(name.length, cookie.length);
            }
        }
        return null;
    }

    getData(){
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
            .then(()=>{ document.cookie = "user=" + this.email.value; window.location.replace('./signup.html')})
            .catch(function(res){ console.log(res) })
    }
}
let app = new App(document.getElementById('title'), document.getElementById('p'))