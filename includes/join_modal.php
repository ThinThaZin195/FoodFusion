<!-- Join Us Button -->
<button id="joinUsBtn"><i class="fa-solid fa-user-group"></i> Join Us</button>

<!-- Join Us Modal -->
<div id="joinUsModal">
  <div class="modal-content">
    <span id="closeModal"><i class="fa-solid fa-xmark"></i></span>
    <h2 style="text-align: center; margin-bottom: 1.5em; background: linear-gradient(135deg, #ff7043, #facc15); -webkit-background-clip: text; background-clip: text; color: transparent;">Join FoodFusion</h2>
    
    <form id="joinForm" method="post" action="pages/register.php">
      <label>First Name:
        <input type="text" name="first_name" placeholder="John" required>
      </label>
      <label>Last Name:
        <input type="text" name="last_name" placeholder="Doe" required>
      </label>
      <label>Email:
        <input type="email" name="email" placeholder="john@example.com" required>
      </label>
      <label>Password:
        <input type="password" name="password" placeholder="••••••••" required>
      </label>
      <button type="submit" style="margin-top: 1em;"><i class="fa-solid fa-paper-plane"></i> Register Now</button>
    </form>
  </div>
</div>

<!-- Modal Script -->
<script>
  if (document.getElementById('joinUsBtn')) {
      const joinBtn = document.getElementById('joinUsBtn');
      const modal = document.getElementById('joinUsModal');
      const closeModal = document.getElementById('closeModal');

      joinBtn.onclick = () => modal.style.display = 'flex';
      closeModal.onclick = () => modal.style.display = 'none';
      window.onclick = (e) => { if (e.target == modal) modal.style.display = 'none'; }
  }
</script>
