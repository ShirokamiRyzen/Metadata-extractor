<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Music Extractor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        #cover {
            width: 375px;
            height: 375px;
            background-position: center;
            background-size: cover;
        }

        .bg {
            background-color: #3a3a3a;
            background-image: url('/img/cover.png');
        }

        .container {
            text-align: left;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        p {
            color: white
        }

        #input {
            color: white;
        }
    </style>
</head>

<body class="bg">

    <center>
        <input type="file" id="input" accept=".mp3, .wav, .flac, .alac, .m4a, .aac">
        <br>
        <br>
        <div id="cover"></div>
        <br>
        <a id="downloadLink" type="button" class="btn btn-primary" style="display: none;">Download cover</a>
        <br>
        <p id="title"></p>
        <p id="artist"></p>
        <p id="album"></p>
        <p id="genre"></p>
    </center>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsmediatags/3.9.5/jsmediatags.min.js"></script>
    <script>
        const jsmediatags = window.jsmediatags;

        document.querySelector("#input").addEventListener("change", (event) => {

            const file = event.target.files[0];

            jsmediatags.read(file, {
                onSuccess: function(tag) {

                    // Array buffer to base64
                    const data = tag.tags.picture.data;
                    const format = tag.tags.picture.format;
                    let base64String = "";
                    for (let i = 0; i < data.length; i++) {
                        base64String += String.fromCharCode(data[i]);
                    }

                    // Output media tags
                    document.querySelector("#cover").style.backgroundImage =
                        `url(data:${format};base64,${window.btoa(base64String)})`;

                    document.querySelector("#title").textContent = "Title: " + tag.tags.title;
                    document.querySelector("#artist").textContent = "Artist: " + tag.tags.artist;
                    document.querySelector("#album").textContent = "Album: " + tag.tags.album;
                    document.querySelector("#genre").textContent = "Genre: " + tag.tags.genre;

                    // Menampilkan tautan unduh
                    const downloadLink = document.querySelector("#downloadLink");
                    downloadLink.style.display = "block";
                    downloadLink.href = `data:${format};base64,${window.btoa(base64String)}`;
                    downloadLink.download = "cover.png"; // Nama file yang akan diunduh
                },
                onError: function(error) {
                    console.log(error);
                }
            });
        });
    </script>
</body>

</html>
