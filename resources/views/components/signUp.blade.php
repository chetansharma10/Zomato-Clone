<div class="dialogBox">
    <!-- Well begun is half done. - Aristotle -->
    <div class="dialogItem">
        <h2 class="type">Sign Up</h2>
        <button class="dialogClose">
            <i class="material-icons">close</i>
        </button>

        <form action="/signUp" method="POST" class="form">
            @csrf
            <input class="extraStyle" type="text" placeholder="Full Name" name="fullName" required>
            <input class="extraStyle" type="email" placeholder="Email" name="email" required>
            <input class="extraStyle" type="password" placeholder="Password" name="password" required>
            <div class="userTypes">
                <span>
                    <label for="one">Consumer</label>
                    <input id="one" type="radio" value="Consumer" name="userType" checked>
                </span>
                <span>
                    <label for="two">Delivery Boy</label>
                    <input id="two" type="radio" value="Delivery Boy" name="userType" >
                </span>
                <span>
                    <label for="three">Seller</label>
                    <input id="three" type="radio" value="Seller" name="userType">
                </span>
            </div>
            <input class="submit"  type="submit" value="Create account" name="createAccount">
        </form>
        <span class="switcher">
            <p>Already have an account?</p>
            <button class="switchOther loginSwitch">Login </button>
        </span>
    </div>
</div>