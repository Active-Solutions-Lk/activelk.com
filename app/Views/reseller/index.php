<?php
$title = "Re-Seller Register | Active Solutions";
$description = "Partner with Active Solutions. Register as an authorized reseller for Synology, BDCOM, DrayTek, and SYNALYZE.";
ob_start();
?>
<div class="page-container">
  <div class="text-center max-w-[650px] mx-auto mb-12">
    <span class="badge inline-block mb-3">Partner Program</span>
    <h1 class="text-[clamp(2rem,4vw,3.2rem)] font-bold mb-4 tracking-[-0.02em] leading-tight">
      Become an Authorized Re-Seller
    </h1>
    <p class="text-navy-600 text-lg leading-relaxed">
      Join our partner network to distribute Synology, BDCOM, DrayTek, Acronis and SYNALYZE enterprise solutions with dedicated technical and pre-sales support.
    </p>
  </div>

  <div class="standard-card max-w-[600px] mx-auto p-[clamp(2rem,4vw,3rem)]">
    <div id="reseller-alert" class="hidden p-4 rounded-lg mb-6 text-[0.95rem]"></div>

    <form id="reseller-form" class="flex flex-col gap-5" method="POST" action="<?= url('/reseller-register') ?>">
      <div>
        <label class="block text-sm font-semibold mb-1.5" for="company_name">Company Name <span class="text-brand">*</span></label>
        <input class="w-full h-[46px] px-4 rounded-[10px] border border-navy/15 font-inherit text-base focus:border-brand focus:ring-1 focus:ring-brand" type="text" id="company_name" name="company_name" required placeholder="Acme IT Solutions (Pvt) Ltd">
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1.5" for="contact_name">Contact Person Name <span class="text-brand">*</span></label>
        <input class="w-full h-[46px] px-4 rounded-[10px] border border-navy/15 font-inherit text-base focus:border-brand focus:ring-1 focus:ring-brand" type="text" id="contact_name" name="contact_name" required placeholder="Jane Perera">
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
          <label class="block text-sm font-semibold mb-1.5" for="email">Work Email <span class="text-brand">*</span></label>
          <input class="w-full h-[46px] px-4 rounded-[10px] border border-navy/15 font-inherit text-base focus:border-brand focus:ring-1 focus:ring-brand" type="email" id="email" name="email" required placeholder="jane@company.lk">
        </div>

        <div>
          <label class="block text-sm font-semibold mb-1.5" for="phone">Phone Number <span class="text-brand">*</span></label>
          <input class="w-full h-[46px] px-4 rounded-[10px] border border-navy/15 font-inherit text-base focus:border-brand focus:ring-1 focus:ring-brand" type="tel" id="phone" name="phone" required placeholder="+94 77 123 4567">
        </div>
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1.5" for="website">Company Website <span class="text-navy-400 font-normal">(Optional)</span></label>
        <input class="w-full h-[46px] px-4 rounded-[10px] border border-navy/15 font-inherit text-base focus:border-brand focus:ring-1 focus:ring-brand" type="url" id="website" name="website" placeholder="https://www.company.lk">
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1.5" for="message">Brands &amp; Partnership Notes <span class="text-navy-400 font-normal">(Optional)</span></label>
        <textarea class="w-full p-4 rounded-[10px] border border-navy/15 font-inherit text-base resize-y focus:border-brand focus:ring-1 focus:ring-brand" id="message" name="message" rows="4" placeholder="Tell us about your target market, key brands of interest, or estimated monthly volume..."></textarea>
      </div>

      <button type="submit" id="reseller-submit" class="btn w-full justify-center h-[50px] text-base mt-2 cursor-pointer border-none gap-2">
        <span>Apply as Re-Seller</span>
        <?= icon('arrow') ?>
      </button>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('reseller-form');
  const alertBox = document.getElementById('reseller-alert');
  const submitBtn = document.getElementById('reseller-submit');
  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    alertBox.className = 'hidden p-4 rounded-lg mb-6 text-[0.95rem]';
    alertBox.textContent = '';

    const originalHtml = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span>Submitting...</span>';

    try {
      const payload = Object.fromEntries(new FormData(form).entries());
      const res = await fetch(form.action, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify(payload),
      });
      const data = await res.json();

      if (res.ok && data.status === 'success') {
        alertBox.className = 'p-4 rounded-lg mb-6 text-[0.95rem] bg-[#ecfdf5] text-[#065f46] border border-[#a7f3d0]';
        alertBox.textContent = data.message || 'Application submitted successfully!';
        form.reset();
      } else {
        const errList = data.errors ? Object.values(data.errors).join(' ') : '';
        alertBox.className = 'p-4 rounded-lg mb-6 text-[0.95rem] bg-[#fef2f2] text-[#991b1b] border border-[#fecaca]';
        alertBox.textContent = errList || data.message || 'Please check your input and try again.';
      }
    } catch (err) {
      alertBox.className = 'p-4 rounded-lg mb-6 text-[0.95rem] bg-[#fef2f2] text-[#991b1b] border border-[#fecaca]';
      alertBox.textContent = 'Network error occurred. Please try again.';
    } finally {
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalHtml;
    }
  });
});
</script>
<?php
$content = ob_get_clean();
require dirname(__DIR__) . '/layout/base.php';
