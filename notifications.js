document.addEventListener('DOMContentLoaded', function() {
    if (!("Notification" in window)) {
        console.log("This browser does not support desktop notification");
    } 
    else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(function (permission) {
            if (permission === "granted") {
                console.log("Notification permission granted.");
                checkForBirthdays();
            }
        });
    }
    function showBirthdayNotification(name) {
        const notification = new Notification('🎉 Happy Birthday! 🎉', {
            body: `Don't forget to wish ${name} a happy birthday today!`,
            icon: 'birthday-cake.png' 
        });
    }

    async function checkForBirthdays() {
        if (Notification.permission !== "granted") {
            return;
        }

        try {
            const response = await fetch('check_birthdays.php');
            const names = await response.json();

            if (names.length > 0) {
                names.forEach(name => {
                    showBirthdayNotification(name);
                });
            }
        } catch (error) {
            console.error('Error checking for birthdays:', error);
        }
    }

    setInterval(checkForBirthdays, 3600000);
});