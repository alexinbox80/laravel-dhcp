/**
 *
 * DashboardDefault
 *
 * Dashboards.Default.html page content scripts. Initialized from scripts.js file.
 *
 *
 */

class DashboardDefault {
  constructor() {
    this._initTour();
  }

  // Dashboard Take a Tour
  _initTour() {
    if (typeof introJs !== 'undefined' && document.getElementById('btnTour') !== null) {
      document.getElementById('btnTour').addEventListener('click', (event) => {
        introJs()
          .setOption('nextLabel', '<span>Далее</span><i class="cs-chevron-right"></i>')
          .setOption('prevLabel', '<i class="cs-chevron-left"></i><span>Назад</span>')
          .setOption('skipLabel', '<i class="cs-close"></i>')
          .setOption('doneLabel', '<i class="cs-check"></i><span>Закрыть</span>')
          .setOption('overlayOpacity', 0.5)
          .start();
      });
    }
  }
}
