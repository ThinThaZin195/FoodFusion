<!-- Join Us Button -->
<button id="joinUsBtn">Join Us</button>

<!-- Join Us Modal -->
<div id="joinUsModal">
  <div class="modal-content">
    <span id="closeModal">&times;</span>
    <h2>Join FoodFusion</h2>
    <form id="joinForm" method="post" action="pages/register.php">
      <label>First Name:<br><input type="text" name="first_name" required></label><br><br>
      <label>Last Name:<br><input type="text" name="last_name" required></label><br><br>
      <label>Email:<br><input type="email" name="email" required></label><br><br>
      <label>Password:<br><input type="password" name="password" required></label><br><br>
      <button type="submit">Register</button>
    </form>
  </div>
</div>

<!-- Modal Script -->
<script>
  const joinBtn = document.getElementById('joinUsBtn');
  const modal = document.getElementById('joinUsModal');
  const closeModal = document.getElementById('closeModal');

  joinBtn.onclick = () => modal.style.display = 'block';
  closeModal.onclick = () => modal.style.display = 'none';
  window.onclick = (e) => { if (e.target == modal) modal.style.display = 'none'; }
</script>
