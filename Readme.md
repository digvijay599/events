
# Special Events 

## API Reference

#### Create Event 
```http
POST /events/create
```
| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `title` | `string` | **Required** |
| `description` | `string` | **Required** |
| `event_start_date` | `date` | **Required** |
| `event_end_date` | `date` | **Required** |
| `event_category` | `array` | **Required** store only category ID in array like [1,2] |

#### Update Event 
```http
PUT /events/update/${id}
```
| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `ID` | `string` | **Required** |
| `title` | `string` | **Required** |
| `description` | `string` | **Required** |
| `event_start_date` | `date` | **Required** |
| `event_end_date` | `date` | **Required** |
| `event_category` | `array` | **Required** store only category ID in array like [1,2] |


#### Get Events List
```http
  GET /events/list
```

#### Get Event by ID
```http
  GET /events/show/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `stiring` | **Required**. Id of item to fetch |

#### Delete Event by ID
```http
  DELETE /events/delete/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `stiring` | **Required**. Id of item to fetch |



## Other Questions

``
 Question 2: Describe one of your most memorable experience with one of your friends in 200-250 words.What was the situation? What was special about them? What made it memorable?
`` 

I was in college, and my friend Manshi and I decided to go on a trip to Puri, a holy city in Odisha, India. We were both interested in learning more about Hinduism, and we wanted to experience the culture and spirituality of the city.

We arrived in Puri on a hot summer day, and we were immediately struck by the hustle and bustle of the city. There were people everywhere, and the streets were filled with shops, temples, and shrines. We made our way to the Jagannath Temple, the most important temple in Puri.

The temple was even more crowded than the streets, and we had to wait in line for hours to get inside. But it was worth the wait. The temple was absolutely stunning, and we were filled with awe as we walked through the halls and gazed at the ornate decorations.

After we left the temple, we wandered around the city for a while. We visited some of the other temples, and we also went to the beach. We spent the evening sitting on the beach, watching the sunset and talking about our lives.

It was a perfect day, and it was one of the most memorable experiences of my life. I will never forget the feeling of being in Puri, surrounded by so much history and culture. And I will always cherish the memories I made with my friend Manshi.

What made this experience so memorable was the beauty of Puri, the sense of spirituality, and the friendship I shared with Manshi. It was a truly unforgettable experience.

Here are some other things that made this experience memorable:

* The hustle and bustle of the city.
* The crowds of people at the Jagannath Temple.
* The beauty of the temple.
* The feeling of awe and wonder.
* The memories I made with my friend Manshi.

I am so grateful for this experience, and I will never forget it. It is one of the many reasons why Manshi is one of my best friends.

``
Question 3: In your opinion (and imagination), what would be the coolest computer / computing device /software / technology? What would it do? What could it do? How would it help?
Please describe your imagination in at least 100 words.
``

In my mind, the coolest technology is artificial intelligence. It would be an intelligent AI-powered code helper. This revolutionary tool would improve the software development process by providing real-time code suggestions, automated debugging, and intelligent error management.

Consider an AI that understands the developer's coding style and context, recommending smart code completion and automated refactoring. It is capable of analysing large codebases, extracting patterns, and providing optimised algorithms for specific tasks.

This artificial intelligence system would shorten development cycles, decrease manual errors, and improve code quality. It could help with complex problem solving, predict future issues, and recommend efficient solutions.

Ultimately, this forward-thinking AI technology would enable software engineers to code faster, smarter, and more accurately, stimulating creativity and pushing the boundaries of software development skills.




