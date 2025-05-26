<!-- Chat WhatsApp dengan teks sambutan -->
<a href="https://wa.me/6281234567890" target="_blank"
   class="fixed z-50 bottom-6 right-6 flex flex-col items-end space-y-2">

  <!-- Balon chat di atas ikon dengan animasi -->
  <div class="relative">
    <div class="absolute bottom-full mb-2 right-3 transform -translate-x-6 fade-slide-up">
      <div class="chat-bubble" id="chatText">
        <!-- Teks akan diisi via JS -->
      </div>
    </div>

    <!-- Ikon WhatsApp -->
    <div class="bg-white hover:bg-gray-100 p-3 rounded-full shadow-lg fade-slide-up" style="animation-delay: 0.3s;">
      <img src="/images/icon-wa.svg" alt="WhatsApp" class="w-6 h-6">
    </div>
  </div>
</a>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const text = "Welcome to Lily Bakery! How can we help you? Tap here to chat with us!";
    const chatText = document.getElementById('chatText');
    let index = 0;

    function type() {
      if (index < text.length) {
        chatText.innerHTML = text.substring(0, index + 1) + '<span class="typing-cursor"></span>';
        index++;
        setTimeout(type, 50); // kecepatan mengetik (50ms per huruf)
      } else {
        // Hapus cursor setelah selesai mengetik
        chatText.innerHTML = text;
      }
    }

    type();
  });
</script>
