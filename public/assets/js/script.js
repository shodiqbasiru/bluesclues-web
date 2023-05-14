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

//  video slider
const slideContainer = document.querySelector(".container-slider");
const slide = document.querySelector(".slides");
const nextBtn = document.getElementById("next");
const prevBtn = document.getElementById("prev");
const interval = 3000;

let slides = document.querySelectorAll(".slide");
let index = 1;
let slideId;

const firstClone = slides[0].cloneNode(true);
const lastClone = slides[slides.length - 1].cloneNode(true);

firstClone.id = "first-clone";
lastClone.id = "last-clone";

slide.append(firstClone);
slide.prepend(lastClone);

const slideWidth = slides[index].clientWidth;

slide.style.transform = `translateX(${-slideWidth * index}px)`;

console.log(slides);

const startSlide = () => {
    slideId = setInterval(() => {
        moveToNextSlide();
    }, interval);
};

const getSlides = () => document.querySelectorAll(".slide");

slide.addEventListener("transitionend", () => {
    slides = getSlides();
    if (slides[index].id === firstClone.id) {
        slide.style.transition = "none";
        index = 1;
        slide.style.transform = `translateX(${-slideWidth * index}px)`;
    }

    if (slides[index].id === lastClone.id) {
        slide.style.transition = "none";
        index = slides.length - 2;
        slide.style.transform = `translateX(${-slideWidth * index}px)`;
    }
});

const moveToNextSlide = () => {
    slides = getSlides();
    if (index >= slides.length - 1) return;
    index++;
    slide.style.transition = ".7s ease-out";
    slide.style.transform = `translateX(${-slideWidth * index}px)`;
};

const moveToPreviousSlide = () => {
    if (index <= 0) return;
    index--;
    slide.style.transition = ".7s ease-out";
    slide.style.transform = `translateX(${-slideWidth * index}px)`;
};

slideContainer.addEventListener("mouseenter", () => {
    clearInterval(slideId);
});

slideContainer.addEventListener("mouseleave", startSlide);
nextBtn.addEventListener("click", moveToNextSlide);
prevBtn.addEventListener("click", moveToPreviousSlide);

startSlide();

// Music section
// media controllers
const playPause = document.querySelector("#play-stop");
const backward = document.querySelector("#backward");
const forward = document.querySelector("#forward");

// record player animation
const circleBig = document.querySelector("#circle-bg");
const circleSm = document.querySelector("#circle-sm");

// playing song
const songName = document.querySelector("#song-name");
const audio = document.querySelector("#audio");
const coverArt = document.querySelector("#cover");
const musicbox = document.querySelector("#musicbox");

// control button images
let playImg = "./assets/img/icons/play-music.png";
let pauseImg = "./assets/img/icons/pause-music.png";

// default controls
playPause.src = playImg;
let isPlaying = true;

const songList = [
    {
        name: "Sure To Marry You",
        source: "./assets/music/Sure to Marry You.mp3",
        cover: "./assets/img/Component 5.png",
    },
    {
        name: "Tamiang Meulit Kana Bitis",
        source: "./assets/music/Tamiang Meulit Kana Bitis.mp3",
        cover: "./assets/img/Component 5.png",
    },
    {
        name: "Mangsa Ka Mangsa",
        source: "./assets/music/Mangsa Ka Mangsa.mp3",
        cover: "./assets/img/Component 5.png",
    },
];
// helper function
function createEle(ele) {
    return document.createElement(ele);
}
function append(parent, child) {
    return parent.append(child);
}
// creating track list
const ol = createEle("ol");
function createPlayList() {
    songList.forEach((song) => {
        let h3 = createEle("h3");
        let li = createEle("li");

        li.classList.add("track-item");
        h3.innerText = song.name;
        append(li, h3);
        append(ol, li);
    });
    append(musicbox, ol);
}

let songIndex = 0;
// preloaded song
loadMusic(songList[songIndex]);

function loadMusic() {
    coverArt.src = songList[songIndex].cover;
    songName.innerText = songList[songIndex].name;
    audio.src = songList[songIndex].source;
}

function playSong() {
    playPause.src = pauseImg;
    circleBig.classList.add("animate");
    circleSm.classList.add("animate");

    audio.play();
}

function pauseSong() {
    playPause.src = playImg;
    circleBig.classList.remove("animate");
    circleSm.classList.remove("animate");

    audio.pause();
}

function nextPlay() {
    songIndex++;
    if (songIndex > songList.length - 1) {
        songIndex = 0;
    }
    loadMusic(songList[songIndex]);
    playSong();
}

function backPlay() {
    songIndex--;
    if (songIndex < 0) {
        songIndex = songList.length - 1;
    }
    loadMusic(songList[songIndex]);
    playSong();
}
function playHandler() {
    isPlaying = !isPlaying;
    //console.log("Change: ",isPlaying)
    isPlaying ? pauseSong() : playSong();
}

// player event
playPause.addEventListener("click", playHandler);
backward.addEventListener("click", backPlay);
forward.addEventListener("click", nextPlay);

createPlayList();

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
