var lightbulb = document.getElementsByClassName('header__lightbulb')[0];
var lightbulbContent = document.getElementsByClassName('lightbulb__content')[0];
var lightbulbViewedButton = document.getElementsByClassName('lightbulb__viewed')[0];

function loadEvents() {
    fetch('/events')
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            lightbulbContent.innerHTML = "";
            if (data.length == 0) {
                lightbulbViewedButton.classList.add("lightbulb__viewed--hidden");
                var p1 = document.createElement("p");
                p1.classList.add("lightbulb__new-task");
                p1.textContent = "Нет новых событий";
                lightbulbContent.appendChild(p1);
            } else {
                lightbulbViewedButton.classList.remove("lightbulb__viewed--hidden");
                data.forEach(element => {
                    var taskId = element['task_id'];
                    var taskName = element['task_name'];
                    var eventType = element['event_type'];
                    var eventText = element['event_text'];

                    var p1 = document.createElement("p");
                    p1.classList.add("lightbulb__new-task", "lightbulb__new-task--" + eventType);

                    var a2 = document.createElement("a");
                    a2.classList.add("link-regular");
                    a2.setAttribute("href", "/task/" + taskId);

                    a2.textContent = taskName;

                    p1.textContent = eventText + " ";
                    p1.appendChild(a2);

                    lightbulbContent.appendChild(p1);
                });
            }
        });
}

lightbulb.addEventListener('mouseover', loadEvents);

lightbulbViewedButton.addEventListener('click', function () {
    fetch('/events/clear')
        .then((response) => {
            if (response.ok) {
                loadEvents();
            }
        });
});
