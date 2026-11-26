<?php
$title = "Contact Us | Active Solutions";
ob_start();
?>
<style>
  .contact-cards-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1.5rem;
    max-width: 1000px;
    margin: 0 auto 2.5rem;
  }
  .contact-info-card {
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 2rem 1.5rem;
    gap: 0.85rem;
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
  }
  .contact-info-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #2a8bff, #0a5cff);
    opacity: 0.85;
  }
  .contact-info-card:hover {
    border-color: rgba(10, 92, 255, 0.28);
  }
  .contact-info-icon {
    width: 3rem;
    height: 3rem;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0a5cff;
    background: linear-gradient(135deg, rgba(42, 139, 255, 0.14), rgba(10, 92, 255, 0.06));
    border: 1px solid rgba(10, 92, 255, 0.18);
    box-shadow: 0 6px 18px rgba(10, 92, 255, 0.12);
  }
  .contact-info-label {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #64748b;
    margin: 0;
  }
  .contact-info-value {
    font-size: 1rem;
    font-weight: 600;
    color: #0f172a;
    line-height: 1.5;
    text-decoration: none;
    transition: color 0.2s ease;
  }
  a.contact-info-value:hover,
  a.contact-info-card:hover .contact-info-value {
    color: #0a5cff;
  }
  .contact-info-hint {
    font-size: 0.8rem;
    color: #64748b;
    margin-top: 0.15rem;
  }
  .contact-form-card {
    max-width: 680px;
    margin: 0 auto;
  }
  .contact-map-card {
    max-width: 1000px;
    margin: 2.5rem auto 0;
    overflow: hidden;
    padding: 0;
    scroll-margin-top: 110px;
  }
  .contact-map-frame {
    width: 100%;
    height: 400px;
    border: 0;
    display: block;
  }
  @media (max-width: 768px) {
    .contact-cards-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
<div class="page-container">
  <div class="text-center max-w-[680px] mx-auto mb-12">
    <span class="badge inline-block mb-3">Get in Touch</span>
    <h1 class="text-[clamp(2rem,4vw,3.2rem)] font-bold mb-4 tracking-[-0.02em] leading-tight">
      Let’s Build Something Reliable
    </h1>
    <p class="text-navy-600 text-lg leading-relaxed">
      If you would like further information on us or our products, please write to us. We will get back at the earliest.
    </p>
  </div>

  <div class="contact-cards-grid">
    <a href="#our-location" id="head-office-card" class="standard-card as-3d-card contact-info-card no-underline cursor-pointer">
      <div class="contact-info-icon">
        <?= icon('home') ?>
      </div>
      <div>
        <h2 class="contact-info-label">Head Office</h2>
        <p class="contact-info-value mt-1">
          32/2-2/1, Nandimithra Place,<br>
          Colombo 06, Sri Lanka
        </p>
        <p class="contact-info-hint">View on map ↓</p>
      </div>
    </a>

    <a href="mailto:sales@activelk.com" class="standard-card as-3d-card contact-info-card no-underline cursor-pointer">
      <div class="contact-info-icon">
        <?= icon('mail') ?>
      </div>
      <div>
        <h2 class="contact-info-label">E-mail</h2>
        <span class="contact-info-value inline-block mt-1">sales@activelk.com</span>
        <p class="contact-info-hint">Send us an inquiry anytime</p>
      </div>
    </a>

    <a href="tel:+94112818691" class="standard-card as-3d-card contact-info-card no-underline cursor-pointer">
      <div class="contact-info-icon">
        <?= icon('headset') ?>
      </div>
      <div>
        <h2 class="contact-info-label">Hot-line</h2>
        <span class="contact-info-value inline-block mt-1">011 2 818 691</span>
        <p class="contact-info-hint">Talk directly with our team</p>
      </div>
    </a>
  </div>

  <div class="standard-card contact-form-card p-[clamp(2rem,4vw,3rem)]">
      <div id="form-alert" class="hidden p-4 rounded-lg mb-6 text-[0.95rem]"></div>

      <form id="contact-form" class="flex flex-col gap-5" method="POST" action="<?= url('/contact') ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div>
            <label class="block text-sm font-semibold mb-1.5" for="name">Name <span class="text-brand">*</span></label>
            <input class="w-full h-[46px] px-4 rounded-[10px] border border-navy/15 font-inherit text-base focus:border-brand focus:ring-1 focus:ring-brand" type="text" id="name" name="name" required placeholder="John Doe">
          </div>

          <div>
            <label class="block text-sm font-semibold mb-1.5" for="phone">Phone</label>
            <input class="w-full h-[46px] px-4 rounded-[10px] border border-navy/15 font-inherit text-base focus:border-brand focus:ring-1 focus:ring-brand" type="tel" id="phone" name="phone" placeholder="011 2 818 691">
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div>
            <label class="block text-sm font-semibold mb-1.5" for="reason">Reason</label>
            <select class="w-full h-[46px] px-4 rounded-[10px] border border-navy/15 font-inherit text-base bg-white focus:border-brand focus:ring-1 focus:ring-brand" id="reason" name="reason">
              <option value="sales">Sales</option>
              <option value="support">Support</option>
              <option value="feedback">Feedback</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-semibold mb-1.5" for="email">E-mail <span class="text-brand">*</span></label>
            <input class="w-full h-[46px] px-4 rounded-[10px] border border-navy/15 font-inherit text-base focus:border-brand focus:ring-1 focus:ring-brand" type="email" id="email" name="email" required placeholder="you@company.com">
          </div>
        </div>

        <div>
          <label class="block text-sm font-semibold mb-1.5" for="message">Message</label>
          <textarea class="w-full p-4 rounded-[10px] border border-navy/15 font-inherit text-base resize-y focus:border-brand focus:ring-1 focus:ring-brand" id="message" name="message" rows="4" placeholder="How can we help you?"></textarea>
        </div>

        <button type="submit" id="contact-submit" class="btn w-full justify-center h-[50px] text-base mt-2 cursor-pointer border-none gap-2">
          <span>Send Message</span>
          <?= icon('arrow') ?>
        </button>
      </form>
  </div>

  <div id="our-location" class="standard-card contact-map-card">
    <div class="p-6 flex flex-wrap items-center justify-between gap-4 border-b border-navy/10">
      <div>
        <h2 class="text-sm font-semibold uppercase tracking-wide text-navy-500">Our Location</h2>
        <p class="text-[0.95rem] text-navy-800 mt-0.5">32/2-2/1, Nandimithra Place, Colombo 06, Sri Lanka</p>
      </div>
      <a class="text-sm font-semibold text-brand hover:underline" href="https://maps.google.com/?q=32/2-2/1,+Nandimithra+Place,+Colombo+06,+Sri+Lanka" target="_blank" rel="noopener noreferrer">
        Open in Google Maps →
      </a>
    </div>
    <iframe
      class="contact-map-frame"
      title="Active Solutions Head Office Map"
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
      src="https://www.google.com/maps/embed?pb=!4v1795601004405!6m8!1m7!1snHSIFx6oE1gTtcdjzksy_g!2m2!1d6.874474966925741!2d79.87511424812617!3f5.25404768750202!4f-4.821043657171302!5f0.7820865974627469" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin">
    </iframe>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const headOfficeCard = document.getElementById('head-office-card');
  const locationCard = document.getElementById('our-location');
  if (headOfficeCard && locationCard) {
    headOfficeCard.addEventListener('click', (e) => {
      e.preventDefault();
      locationCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  }

  const form = document.getElementById('contact-form');
  const alertBox = document.getElementById('form-alert');
  const submitBtn = document.getElementById('contact-submit');
  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    alertBox.className = 'hidden p-4 rounded-lg mb-6 text-[0.95rem]';
    alertBox.textContent = '';

    const originalHtml = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span>Sending...</span>';

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
        alertBox.textContent = data.message || 'Thank you! Your message was received.';
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
