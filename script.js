// Galeria zdjęć - carousel functionality
const images = [
	{ src: "360.png", alt: "Fotobudka 360" },
	{ src: "mirror.jpg", alt: "Fotolustro" },
	{ src: "heavysmoke.jpg", alt: "Ciężki dym" },
	{ src: "fountain.jpg", alt: "Fontanny iskier" },
	{ src: "neons.jpg", alt: "Neonowe napisy" },
];

let currentIndex = 1; // Zaczynamy od drugiego zdjęcia (mirror.jpg), zgodnie z HTML
let isAnimating = false; // Flaga zapobiegająca nakładaniu się animacji

function updateCarousel() {
	if (isAnimating) return; // Zapobiegaj nakładaniu się animacji

	isAnimating = true;
	//console.log("Current index:", currentIndex);

	const leftSlide = document.querySelector(".image-slide-left img");
	const centerSlide = document.querySelector(".image-slide-center img");
	const rightSlide = document.querySelector(".image-slide-right img");

	const leftIndex = (currentIndex - 1 + images.length) % images.length;
	const rightIndex = (currentIndex + 1) % images.length;

	//console.log("Indices:", leftIndex, currentIndex, rightIndex);

	// Animacja fadeOut dla wszystkich slajdów
	const tl = gsap.timeline({
		onComplete: () => {
			isAnimating = false;
		},
	});

	// Fade out wszystkich obrazów
	tl.to([leftSlide, centerSlide, rightSlide], {
		opacity: 0,
		scale: 0.9,
		duration: 0.3,
		ease: "power2.inOut",
	})
		// Zmiana źródeł obrazów
		.call(() => {
			leftSlide.src = images[leftIndex].src;
			leftSlide.alt = images[leftIndex].alt;

			centerSlide.src = images[currentIndex].src;
			centerSlide.alt = images[currentIndex].alt;

			rightSlide.src = images[rightIndex].src;
			rightSlide.alt = images[rightIndex].alt;
		})
		// Fade in z animacją
		.to(
			[leftSlide, rightSlide],
			{
				opacity: 0.6,
				scale: 1,
				duration: 0.4,
				ease: "power2.out",
			},
			"+=0.1"
		)
		.to(
			centerSlide,
			{
				opacity: 1,
				scale: 1,
				duration: 0.4,
				ease: "power2.out",
			},
			"-=0.3"
		)
		// Dodaj subtelny efekt pulsowania dla środkowego obrazu
		.to(
			centerSlide,
			{
				scale: 1.02,
				duration: 0.2,
				ease: "power2.inOut",
				yoyo: true,
				repeat: 1,
			},
			"-=0.2"
		);
}

// Make these functions global so they can be called from HTML onclick attributes
window.nextImage = function () {
	if (isAnimating) return; // Zapobiegaj szybkiemu klikaniu

	currentIndex = (currentIndex + 1) % images.length;

	// Dodaj animację przycisku
	const rightButton = document.querySelector(".carousel-arrow-right");
	gsap.to(rightButton, {
		scale: 0.9,
		duration: 0.1,
		ease: "power2.inOut",
		yoyo: true,
		repeat: 1,
	});

	updateCarousel();
};

window.prevImage = function () {
	if (isAnimating) return; // Zapobiegaj szybkiemu klikaniu

	currentIndex = (currentIndex - 1 + images.length) % images.length;

	// Dodaj animację przycisku
	const leftButton = document.querySelector(".carousel-arrow-left");
	gsap.to(leftButton, {
		scale: 0.9,
		duration: 0.1,
		ease: "power2.inOut",
		yoyo: true,
		repeat: 1,
	});

	updateCarousel();
};

// Add scroll handling
document.addEventListener("DOMContentLoaded", function () {
	const header = document.querySelector(".header");
	const navLinks = document.querySelectorAll(".nav-menu a");
	const mainContent = document.querySelector("main");
	const allSections = [mainContent, ...document.querySelectorAll("section")];
	const footer = document.querySelector("footer");
	if (footer) allSections.push(footer);

	function highlightNavOnScroll() {
		const currentScroll = window.scrollY;
		const windowHeight = window.innerHeight;
		const documentHeight = document.documentElement.scrollHeight;

		// Header shrink effect with GSAP
		if (currentScroll > 0) {
			if (!header.classList.contains("scrolled")) {
				header.classList.add("scrolled");
				gsap.to(header, {
					backdropFilter: "blur(10px)",
					background: "rgba(238, 201, 210, 0.95)",
					duration: 0.3,
					ease: "power2.out",
				});
			}
		} else {
			if (header.classList.contains("scrolled")) {
				header.classList.remove("scrolled");
				gsap.to(header, {
					backdropFilter: "none",
					background: "#eec9d2",
					duration: 0.3,
					ease: "power2.out",
				});
			}
			// Gdy jesteśmy na górze strony, aktywuj link "Strona główna"
			navLinks.forEach((link) => {
				link.classList.remove("active");
				if (link.getAttribute("href") === "#") {
					link.classList.add("active");
				}
			});
			return;
		}

		// Highlight nav items based on section
		let currentSection = null;

		// Check if we're at the very bottom of the page
		if (window.innerHeight + window.scrollY >= documentHeight - 100) {
			currentSection = footer;
		} else {
			// Otherwise check each section
			allSections.forEach((section) => {
				const sectionTop = section.offsetTop - 100;
				const sectionBottom = sectionTop + section.offsetHeight;

				if (
					currentScroll >= sectionTop &&
					currentScroll < sectionBottom
				) {
					currentSection = section;
				}
			});
		}

		// Update active state with smooth transitions
		if (currentSection) {
			navLinks.forEach((link) => {
				const wasActive = link.classList.contains("active");
				link.classList.remove("active");
				if (link.getAttribute("href") === "#" + currentSection.id) {
					link.classList.add("active");
					if (!wasActive) {
						gsap.fromTo(
							link,
							{ scale: 1 },
							{
								scale: 1.05,
								duration: 0.2,
								yoyo: true,
								repeat: 1,
								ease: "power2.inOut",
							}
						);
					}
				}
			});
		}
	}

	window.addEventListener("scroll", highlightNavOnScroll);
	highlightNavOnScroll();
});

// Add smooth scrolling functionality
document.addEventListener("DOMContentLoaded", function () {
	const navLinks = document.querySelectorAll(".nav-menu a");

	navLinks.forEach((link) => {
		link.addEventListener("click", function (e) {
			e.preventDefault();

			const targetId = this.getAttribute("href");

			if (targetId === "#") {
				// Scroll to top if it's home link
				gsap.to(window, {
					duration: 1.2,
					scrollTo: 0,
					ease: "power2.inOut",
				});
			} else {
				const targetElement = document.querySelector(targetId);
				if (targetElement) {
					gsap.to(window, {
						duration: 1.2,
						scrollTo: {
							y: targetElement,
							offsetY: 80,
						},
						ease: "power2.inOut",
					});
				}
			}
		});
	});
});

// Add video start time functionality
document.addEventListener("DOMContentLoaded", function () {
	// Set different start times for videos
	const videos = document.querySelectorAll(
		".photo-frame video[data-start-time]"
	);

	videos.forEach((video) => {
		const startTime = parseFloat(video.getAttribute("data-start-time"));

		video.addEventListener("loadedmetadata", function () {
			// Set the start time
			this.currentTime = startTime;
		});

		// Handle loop restart at different time
		video.addEventListener("ended", function () {
			this.currentTime = startTime;
			this.play();
		});

		// Ensure video starts at correct time even after seeking
		video.addEventListener("seeked", function () {
			if (!this.seeking && this.currentTime < startTime) {
				this.currentTime = startTime;
			}
		});
	});

	// Register ScrollTrigger plugin
	gsap.registerPlugin(ScrollTrigger);

	// Initial setup - hide elements
	gsap.set(".nav-menu li", { opacity: 0, y: -20 });
	gsap.set(".social-icons a", { opacity: 0, y: -20, rotation: -180 });
	gsap.set(".photo-frame", { opacity: 0, scale: 0.8, rotation: 0 });
	gsap.set(".contact-item", { opacity: 0, x: -50 });
	gsap.set(".offer-card", { opacity: 0, y: 100, rotateX: -30 });
	gsap.set(".stat-card", { opacity: 0, y: -30 });
	gsap.set(".welcome-header h2", { opacity: 0, y: 50 });
	gsap.set(".welcome-header p", { opacity: 0, y: 30 });

	// Usuń lub zakomentuj animację parallax dla tła
	/*
    gsap.to("body", {
        backgroundPosition: "50% 100px",
        ease: "none",
        scrollTrigger: {
            trigger: "body",
            start: "top top",
            end: "bottom top",
            scrub: true,
        },
    });
    */

	// Header entrance animation
	const headerTimeline = gsap.timeline();
	headerTimeline
		.to(".nav-menu li", {
			opacity: 1,
			y: 0,
			duration: 0.6,
			stagger: 0.1,
			ease: "back.out(1.7)",
		})
		.to(
			".social-icons a",
			{
				opacity: 1,
				y: 0,
				rotation: 0,
				duration: 0.6,
				stagger: 0.15,
				ease: "back.out(1.7)",
			},
			"-=0.4"
		);

	// Photo frames animation with enhanced effects
	const framesTimeline = gsap.timeline({
		scrollTrigger: {
			trigger: ".photo-gallery",
			start: "top center+=100",
			toggleActions: "play none none reverse",
		},
	});

	// Sprawdź czy jesteśmy w trybie mobilnym
	const isMobile = window.innerWidth <= 768;

	if (isMobile) {
		// Na mobilnym - animacja od 0° do docelowych kątów
		framesTimeline
			.to(".photo-frame:nth-child(1)", {
				opacity: 1,
				scale: 1,
				rotation: -5,
				duration: 0.8,
				ease: "power2.out",
			})
			.to(
				".photo-frame:nth-child(2)",
				{
					opacity: 1,
					scale: 1,
					rotation: 4,
					duration: 0.8,
					ease: "power2.out",
				},
				"-=0.65"
			)
			.to(
				".photo-frame:nth-child(3)",
				{
					opacity: 1,
					scale: 1,
					rotation: -6,
					duration: 0.8,
					ease: "power2.out",
				},
				"-=0.65"
			)
			.to(
				".photo-frame:nth-child(4)",
				{
					opacity: 1,
					scale: 1,
					rotation: 5,
					duration: 0.8,
					ease: "power2.out",
				},
				"-=0.65"
			);
	} else {
		// Na desktop - normalna animacja bez przechylenia
		framesTimeline.to(".photo-frame", {
			opacity: 1,
			scale: 1,
			duration: 0.8,
			stagger: 0.15,
			ease: "power2.out",
		});
	}

	// Welcome section animation
	gsap.timeline({
		scrollTrigger: {
			trigger: ".welcome-section",
			start: "top center+=200",
			toggleActions: "play none none reverse",
		},
	})
		.to(".welcome-header h2", {
			opacity: 1,
			y: 0,
			duration: 0.8,
			ease: "power3.out",
		})
		.to(
			".welcome-header p",
			{
				opacity: 1,
				y: 0,
				duration: 0.6,
				ease: "power2.out",
			},
			"-=0.4"
		);

	// Offer cards animation with staggered 3D effects
	ScrollTrigger.batch(".offer-card", {
		onEnter: (elements) => {
			gsap.to(elements, {
				opacity: 1,
				y: 0,
				rotateX: 0,
				duration: 1,
				stagger: 0.2,
				ease: "back.out(1.4)",
				transformOrigin: "center bottom",
			});
		},
		onLeave: (elements) => {
			gsap.to(elements, {
				opacity: 0.3,
				y: 50,
				duration: 0.5,
				stagger: 0.1,
				ease: "power2.inOut",
			});
		},
		onEnterBack: (elements) => {
			gsap.to(elements, {
				opacity: 1,
				y: 0,
				duration: 0.8,
				stagger: 0.1,
				ease: "power2.out",
			});
		},
		start: "top bottom-=100",
		end: "bottom top+=100",
	});

	// Stats section with counter animation
	const statCards = document.querySelectorAll(".stat-card");

	gsap.timeline({
		scrollTrigger: {
			trigger: ".stats-section",
			start: "top center+=100",
			toggleActions: "play none none reverse",
		},
	}).to(".stat-card", {
		opacity: 1,
		scale: 1,
		rotation: 0,
		duration: 1.2,
		stagger: 0.1,
		ease: "power2.out",
		onComplete: () => {
			// Animate numbers counting up
			statCards.forEach((card) => {
				const numberElement = card.querySelector(".stat-number");
				const finalText = numberElement.textContent;

				if (finalText.includes("+")) {
					const number = parseInt(finalText.replace("+", ""));
					gsap.from(
						{ value: 50 },
						{
							value: number,
							duration: 2,
							ease: "power2.out",
							onUpdate: function () {
								numberElement.textContent =
									Math.round(this.targets()[0].value) + "+";
							},
						}
					);
				} else if (finalText.includes("lat")) {
					const number = parseInt(finalText.replace(" lat", ""));
					gsap.from(
						{ value: 5 },
						{
							value: number,
							duration: 2,
							ease: "power2.out",
							onUpdate: function () {
								numberElement.textContent =
									Math.round(this.targets()[0].value) +
									" lat";
							},
						}
					);
				}
			});
		},
	});

	// Footer contact items animation
	gsap.timeline({
		scrollTrigger: {
			trigger: "#contact",
			start: "top center+=200",
			toggleActions: "play none none reverse",
		},
	})
		.to(".contact-item", {
			opacity: 1,
			x: 0,
			duration: 0.8,
			stagger: 0.2,
			ease: "back.out(1.4)",
		})
		.from(
			".contact-item img",
			{
				rotation: 360,
				scale: 0,
				duration: 0.6,
				stagger: 0.15,
				ease: "back.out(1.7)",
			},
			"-=0.6"
		);

	// Hover animations for interactive elements
	document.querySelectorAll(".offer-card").forEach((card) => {
		card.addEventListener("mouseenter", () => {
			gsap.to(card, {
				scale: 1.03,
				y: -10,
				duration: 0.4,
				ease: "power2.out",
			});
		});

		card.addEventListener("mouseleave", () => {
			gsap.to(card, {
				scale: 1,
				y: 0,
				duration: 0.4,
				ease: "power2.out",
			});
		});
	});

	// Initialize carousel
	updateCarousel();

	// Mouse parallax effect for main gallery - tylko na desktop
	const photoGallery = document.querySelector(".photo-gallery");
	if (photoGallery && !isMobile) {
		photoGallery.addEventListener("mousemove", (e) => {
			const rect = photoGallery.getBoundingClientRect();
			const x = (e.clientX - rect.left) / rect.width - 0.5;
			const y = (e.clientY - rect.top) / rect.height - 0.5;

			gsap.to(".photo-frame", {
				x: x * 20,
				y: y * 20,
				duration: 0.3,
				ease: "power2.out",
				stagger: 0.05,
			});
		});

		photoGallery.addEventListener("mouseleave", () => {
			gsap.to(".photo-frame", {
				x: 0,
				y: 0,
				duration: 0.5,
				ease: "power2.out",
				stagger: 0.05,
			});
		});
	}

	// Text reveal animation for section headings
	ScrollTrigger.batch("h3", {
		onEnter: (elements) => {
			elements.forEach((el) => {
				const text = el.textContent;
				el.innerHTML = text
					.split("")
					.map((char) =>
						char === " "
							? " "
							: `<span style="display:inline-block;">${char}</span>`
					)
					.join("");

				gsap.from(el.querySelectorAll("span"), {
					y: 50,
					opacity: 0,
					duration: 0.8,
					stagger: 0.02,
					ease: "back.out(1.7)",
				});
			});
		},
	});
});
