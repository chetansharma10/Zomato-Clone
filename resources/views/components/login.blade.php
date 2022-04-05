<div class="dialogBox2">
    <!-- Well begun is half done. - Aristotle -->
    <div class="dialogItem">
        <h2 class="type">Login</h2>
        <button class="dialogClose2">
            <i class="material-icons">close</i>
        </button>

        <form action="/login" method="POST" class="form">
            @csrf
            <input class="extraStyle" type="email" placeholder="Email" name="email">
            <input class="extraStyle" type="password" placeholder="Password" name="password">
            <input class="submit" type="submit" value="Sign In">
        </form>
        <span class="switcher">
            <p>New to Zomato?</p>
            <button class="switchOther signUpSwitch">Create an account</button>
        </span>

    </div>
</div>