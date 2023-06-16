var swiper = new Swiper(".mySwiper", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: "auto",
    spaceBetween: 50,
    rewind: true,
    coverflowEffect: {
        rotate: 0,
        stretch: 0,
        depth: 100,
        modifier: 1.5,
        slideShadows: true,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

var num = 50;

$(window).bind("scroll", function () {
    if ($(window).scrollTop() > num) {
        $("#navbar").addClass("fixNav");
    } else {
        $("#navbar").removeClass("fixNav");
    }
});

// looping video home

// Get the modal element
var modal = document.getElementsByClassName("modal");

// Get the button that closes the modal
var closeBtn = document.getElementsByClassName("close");

// When the user clicks the close button, close the modal
for (var i = 0; i < closeBtn.length; i++) {
    closeBtn[i].onclick = function () {
        for (var j = 0; j < modal.length; j++) {
            modal[j].style.display = "none";
        }
    };
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    for (var i = 0; i < modal.length; i++) {
        if (event.target == modal[i]) {
            modal[i].style.display = "none";
        }
    }
};

// Open the modal when the user clicks on the thumbnail
var thumbnail = document.getElementsByClassName("thumbnail-container");

for (var i = 0; i < thumbnail.length; i++) {
    thumbnail[i].onclick = function () {
        var video = this.nextElementSibling;
        video.style.display = "block";
        video
            .getElementsByTagName("iframe")[0]
            .setAttribute(
                "src",
                "https://www.youtube.com/embed/" +
                    this.getAttribute("data-video-id")
            );
    };
}

function loadYouTubeVideo() {
    var videoDiv = document.getElementsByClassName("video-placeholder");

    for (var i = 0; i < videoDiv.length; i++) {
        var videoId = videoDiv[i].getAttribute("data-video-id");
        var iframe = document.createElement("iframe");

        // Set atribut iframe untuk memuat video YouTube
        iframe.setAttribute("src", "https://www.youtube.com/embed/" + videoId);
        iframe.setAttribute("allowfullscreen", "");
        iframe.setAttribute("allow", "autoplay; encrypted-media");
        videoDiv[i].appendChild(iframe);
    }
}

// Fungsi untuk memeriksa apakah elemen berada dalam viewport
function isElementInViewport(element) {
    var rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <=
            (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <=
            (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Fungsi untuk memuat video saat elemen masuk dalam viewport
function lazyLoadVideos() {
    var videoDiv = document.getElementsByClassName("video-placeholder");

    for (var i = 0; i < videoDiv.length; i++) {
        if (isElementInViewport(videoDiv[i])) {
            loadYouTubeVideo();
            break;
        }
    }
}

// Tambahkan event listener untuk memanggil lazyLoadVideos saat halaman digulir
window.addEventListener("scroll", lazyLoadVideos);

// newsPage

var page = 1;
$("#load-more").on("click", function () {
    page++;
    $.ajax({
        url: "?page=" + page,
        type: "get",
        datatype: "html",
        beforeSend: function () {
            $("#load-more").text("Loading...");
        },
    })
        .done(function (data) {
            if (data.length == 0) {
                $("#load-more").remove();
                return;
            }
            $("#news").append(data);
            $("#load-more").text("Load More");
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            alert("Server not responding...");
        });
});

// videos page
// var videoContainer = document.getElementById("#video-container");
// var videoPlayer = document.getElementById("#video-player");

// // Add click event listener to each video thumbnail
// var thumbnails = document.querySelectorAll(".video-thumbnail ");
// thumbnails.forEach(function (thumbnail) {
//     thumbnail.addEventListener("click", function () {
//         // Get the video ID from the data-video-id attribute
//         var videoId = this.getAttribute("data-video-id");

//         // Set the src attribute of the video player with the video ID
//         videoPlayer.setAttribute(
//             "src",
//             "https://www.youtube.com/embed/" + videoId
//         );

//         // Show the video player container
//         videoContainer.style.display = "block";
//     });
// });

// // Add click event listener to the video player container to hide it when clicked
// videoContainer.addEventListener("click", function () {
//     videoPlayer.setAttribute("src", "");
//     videoContainer.style.display = "none";
// });
