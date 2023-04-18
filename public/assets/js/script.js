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
