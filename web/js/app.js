class App{

    constructor(title, p){
        this.title = title;
        this.p = p
        this.user = this.getCookie("user");
        if(this.user == null){
            window.location.replace('./signup.html')
        }
            this.getData()
            console.log(this.userData);
            console.log(this.articleData)
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

    async getData(){
        await fetch("http://localhost:8080/api/getData.php",
            {
                headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
                },
                method: "POST",
                credentials: 'include',
                body: JSON.stringify({"email":this.user})
            })
            .then(response => response.json()) // Parse the JSON response
            .then(data => {
                // Handle the response data here
                console.log("Response from the server:", data);

                // Save the response data to a variable or use it as needed
                this.userData = data;
            })
            
        await fetch("../data/data.json").then(response =>{
            return response.json();
            }).then(data =>{
                this.articleData = data;
            });
        
    }
}
let app = new App(document.getElementById('title'), document.getElementById('p'))