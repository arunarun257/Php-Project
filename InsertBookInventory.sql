USE Project1;
INSERT INTO bookinventory (isbn, title, author, image, description, price, quantity) VALUES
('9388754085', 'The 3 Mistakes Of My Life', 'Chetan Bhagat', 'three_mistakes.jpg', 
'A word of caution: that you might find minor spoilers. The 3 mistakes of my life gives a nice perspective of life in Gujarat. 
 The characters are three ordinary men who start a business venture and strive to make it big. They are the owners of a sports goods store. They have their own fears and philosophies in life. 
 Omi fears he will end up being the priest of the temple. Ish fears he will never be able to live his dreams of being a cricketer through Ali.
 Vidya fears she will end up as one of those doctors who didnt want to be a doctor. Govind appears focused and ambitious though.
 The events happen amidst the Bhuj earthquake and the Godhra riots.', 
 '30.00', 4),
 ('9789380658742', 'Half Girlfriend', 'Chetan Bhagat', 'half_girl.jpg', 
 'Once upon a time, there was a Bihari boy called Madhav. He fell in love with a rich girl from Delhi called Riya. 
 Madhav didnt speak English well. Riya did. Madhav wanted a relationship. Riya didnt. Riya just wanted friendship. Madhav didnt.
 Riya suggested a compromise. She agreed to be his half-girlfriend. From the author of the blockbuster novels Five Point Someone,
 One Night @ the Call Center, The 3 Mistakes of My Life, 2 States and Revolution 2020 comes a simple and
 beautiful love story that will touch your heart and inspire you to chase your dreams.', 
 '20.00', 4),
 ('9789380658797', '2 States : The Story of My Marriage', 'Chetan Bhagat', 'two_states.jpg', 
 'Adapted as a hit film, this book is the fourth in Bhagats list of novels and also the fourth one to be adapted as
 a movie. This fun-filled love story that gets complicated when the question of marriage comes up,
 is a loose adaptation of Chetan Bhagats own marriage. 
 This is a story of a love affair between two IIM students hailing from two different states, 
 Punjab and Tamil Nadu. Miles apart in distance and custom, Krish and Ananyas love blossoms
 within the confines of their college walls. But with the end of college and beginning of a career, 
 the question of marriage does not stand far away.',
 '25.00', 4),
 ('9789382618348', 'One Indian Girl', 'Chetan Bhagat', 'one_girl.jpg',
 'Hi. I’m Radhika Mehta and I’m getting married this week. I work at Goldman Sachs, an investment bank. 
 Thank you for reading my story. However, let me warn you: you may not like me too much.
  One, I make a lot of money. Two, I have an opinion about everything. Three, I have had a boyfriend before. Okay, maybe two.
  Now, if I was a man, one might be cool with it. But since I am a girl, these three things I mentioned don’t really make me too likeable, do they?',
 '28.00', 5),
 ('9789386224583', '400 Days', 'Chetan Bhagat', '400days.jpg',
 '12-year-old Siya has been missing nine months. It’s a cold case, but Keshav wants to help her mother, Alia, who refuses to give up. Welcome to 400 Days―a mystery and romance story like no other.
  ‘My daughter Siya was kidnapped. Nine months ago,’ Alia said.
   The police had given up. They called it a cold case. Even the rest of her family had stopped searching.',
  '25.00', 3);




INSERT INTO `customers` (`customerid`, `firstname`, `lastname`, `address`, `city`, `zip_code`, `country`) VALUES
(14, 'Arun', 'Gopalakrishnan', '123 Linden Dr', 'Cambridge', 'N3H 0C9', 'Canada'),
(15, 'James', 'Raju', '123 Linden Dr', 'Cambridge', 'N3H 0C9', 'Canada'),
(16, 'Vishnu', 'VS', '445 Linden Dr', 'Cambridge', 'N3H 0C9', 'Canada');



INSERT INTO `bookinventoryorder` (`orderid`, `customerid`, `isbn`, `amount`, `date`) VALUES
(24, 14, '9789386224583', '25.00', '2021-07-01 09:15:30'),
(25, 15, '9789386224583', '25.00', '2021-07-01 09:16:19'),
(26, 14, '9789380658742', '20.00', '2021-07-01 09:17:07'),
(27, 16, '9789380658797', '25.00', '2021-07-01 09:18:01'),
(28, 14, '9388754085', '30.00', '2021-07-01 09:18:29');



INSERT INTO `paymentdetails` (`paymentid`, `customerid`, `cardnumber`, `expirydate`, `cvv`, `paymentdate`) VALUES
(31, 14, '1234 1224 1224 1234', '1999', '223', '2021-07-01 09:15:30'),
(32, 15, '1234 1224 1224 1234', '1999', '223', '2021-07-01 09:16:19'),
(33, 14, '1234 1224 1224 1234', '2022-01-22', '223', '2021-07-01 09:17:07'),
(34, 16, '1234 1224 1224', '2006', '121', '2021-07-01 09:18:01'),
(35, 14, '1234 1224 1224 1234', '2022-01-22', '223', '2021-07-01 09:18:29');
COMMIT;
