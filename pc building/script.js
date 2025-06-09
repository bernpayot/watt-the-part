document.addEventListener('DOMContentLoaded', () => {
  const params = new URLSearchParams(window.location.search);
  const component = params.get('open');

  if (component) {
    const detailsPanel = document.getElementById(`${component}-details`);
    if (detailsPanel) {
      detailsPanel.style.display = 'flex';
      // Optional scroll:
      // detailsPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }
});
