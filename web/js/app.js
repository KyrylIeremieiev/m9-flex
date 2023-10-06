fetch("http://localhost:8080/api/api.php",
        {
            headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
            },
            method: "POST",
            body: JSON.stringify({"email":'test', 'pass':'test'})
        })
        .then(function(res){ console.log(res) })
        .catch(function(res){ console.log(res) })