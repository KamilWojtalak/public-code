// Turn on hot module replacement
if (module.hot) {
  module.hot.accept();
}

// Function that is responsible for toggling fixed class for navigation
(async function () {
  // get our nav container and threshold
  const nav = document.querySelector(".header__nav");
  const sectionNavThreshold = document.querySelector("#section_1");

  // nav fixed class name
  const NAV_FIXED_CLASS = 'header__nav_fixed';

  // observer options objects
  const navObserverOptions = {
    root: null,
    threshold: .9,
  };

  // nav observer
  const navObserver = new IntersectionObserver((entries, _) => {
    // if is not intersecting return
    if(!entries?.[0]?.isIntersecting) return;

    // toggle nav class
    nav.classList.toggle(NAV_FIXED_CLASS)
  }, navObserverOptions);

  // observe first section
  navObserver.observe(sectionNavThreshold);
})();
