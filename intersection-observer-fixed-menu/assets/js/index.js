if (module.hot) {
  module.hot.accept();
}

(async function () {
  const nav = document.querySelector(".header__nav");
  const sectionNavThreshold = document.querySelector("#section_1");

  const NAV_TOGGLE_CLASS = 'header__nav_fixed';

  const navObserverOptions = {
    root: null,
    threshold: 0.9,
  };

  const navObserver = new IntersectionObserver(function (entries, observer) {
    // console.log(entries, observer);
    if(!entries?.[0]?.isIntersecting) return;

    nav.classList.toggle(NAV_TOGGLE_CLASS)
  }, navObserverOptions);

  navObserver.observe(sectionNavThreshold);
})();
