
    // Lazy Loadin
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.remove("blur");
            }
        });
    });

    document.querySelectorAll("img.lazy").forEach(image => {
        observer.observe(image);
    });