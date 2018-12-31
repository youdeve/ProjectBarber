const puppeteer = require('puppeteer');

(async () => {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();
  await page.goto('http://localhost:8000/user/prestation', {waitUntil: 'networkidle2'});
  await page.pdf({path: 'facture.pdf', format: 'A4'});

  await browser.close();
})();
