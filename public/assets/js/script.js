var swiper = new Swiper(".mySwiper", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: "auto",
    spaceBetween: 100,
    loop: true,
    coverflowEffect: {
        rotate: 0,
        stretch: 0,
        depth: 150,
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
    on: {
        slideChange: function () {
            var activeSlide = this.slides[this.activeIndex];
            var title = activeSlide.querySelector(".overlay").dataset.title;
            document.querySelector(".video-title").textContent = title;
        },
    },
    autoplay: {
        delay: 3000, // Waktu tunda antara slide (dalam milidetik)
        disableOnInteraction: false, // Jangan hentikan autoplay saat pengguna berinteraksi dengan slider
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

// video page
var videoContainer = document.getElementById("video-container");
var videoPlayer = document.getElementById("video-player");

// Add click event listener to each video thumbnail
var thumbnails = document.querySelectorAll(".video-thumbnail, .overlay");
thumbnails.forEach(function (thumbnail) {
    thumbnail.addEventListener("click", function () {
        // Get the video ID from the data-video-id attribute
        var videoId = this.getAttribute("data-video-id");

        // Set the src attribute of the video player with the video ID
        videoPlayer.setAttribute(
            "src",
            "https://www.youtube.com/embed/" + videoId
        );

        // Show the video player container
        videoContainer.style.display = "block";
    });
});

// Add click event listener to the video player container to hide it when clicked
videoContainer.addEventListener("click", function () {
    videoPlayer.setAttribute("src", "");
    videoContainer.style.display = "none";
});
// Get the modal element
var modal = document.getElementsByClassName("modal");

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    for (var i = 0; i < modal.length; i++) {
        if (event.target == modal[i]) {
            modal[i].style.display = "none";
        }
    }
};

// Add click event listener to the close button
var closeButton = document.getElementById("close-button");
closeButton.addEventListener("click", function () {
    videoPlayer.setAttribute("src", "");
    videoContainer.style.display = "none";
});
