<?php
$title = "Contact Us | Active Solutions";
ob_start();
?>
<div class="page-container">
  <div class="text-center max-w-[650px] mx-auto mb-12">
    <span class="badge inline-block mb-3">Get in Touch</span>
    <h1 class="text-[clamp(2rem,4vw,3.2rem)] font-bold mb-4 tracking-[-0.02em] leading-tight">
      Let’s Build Something Reliable
    </h1>
    <p class="text-navy-600 text-lg leading-relaxed">
      Have a storage, networking or security inquiry? Talk directly with our system architects.
    </p>
  </div>

  <div class="standard-card max-w-[600px] mx-auto p-[clamp(2rem,4vw,3rem)]">
    <div id="form-alert" class="hidden p-4 rounded-lg mb-6 text-[0.95rem]"></div>

    <form id="contact-form" class="flex flex-col gap-5">
      <div>
        <label class="block text-sm font-semibold mb-1.5" for="name">Your Name</label>
        <input class="w-full h-[46px] px-4 rounded-[10px] border border-navy/15 font-inherit text-base focus:border-brand focus:ring-1 focus:ring-brand" type="text" id="name" name="name" required placeholder="John Doe">
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1.5" for="email">Work Email</label>
        <input class="w-full h-[46px] px-4 rounded-[10px] border border-navy/15 font-inherit text-base focus:border-brand focus:ring-1 focus:ring-brand" type="email" id="email" name="email" required placeholder="john@company.com">
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1.5" for="interest">Area of Interest</label>
        <select class="w-full h-[46px] px-4 rounded-[10px] border border-navy/15 font-inherit text-base bg-white focus:border-brand focus:ring-1 focus:ring-brand" id="interest" name="interest">
          <option value="storage">Storage Solutions (Synology NAS)</option>
          <option value="switching">Enterprise Switching (BDCOM)</option>
          <option value="routing">Security & Routing (DrayTek)</option>
          <option value="software">SYNALYZE Log Analytics</option>
          <option value="general">General Infrastructure Inquiry</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1.5" for="message">Project Details</label>
        <textarea class="w-full p-4 rounded-[10px] border border-navy/15 font-inherit text-base resize-y focus:border-brand focus:ring-1 focus:ring-brand" id="message" name="message" rows="4" placeholder="Describe your network or capacity requirements..."></textarea>
      </div>

      <button type="submit" class="btn w-full justify-center h-[50px] text-base mt-2 cursor-pointer border-none">
        <span>Send Inquiry</span>
        <?= icon('arrow') ?>
      </button>
    </form>
  </div>
</div>
<?php
$content = ob_get_clean();
require dirname(__DIR__) . '/layout/base.php';
