# wichteln
Simple PHP page for Secret Santa drawing made via prompting ChatGpt

## DEV
Command `./development.sh` builds and runs simple php Docker container

## Use
* maintain list of persons to choose from in form of `key=value` pairs in [`data.txt`](data.txt) where key is then the query parameter for the draw
* run [`./development.sh`](development.sh)
* open page (localhost)[http://localhost:8080/?key=key-wichtel]
* random person is drawn and then stored for reference in [`draw.txt`](draw.txt) in form of `key-wichtel=key-random-person`
* page shows the randomly chosen person on the first call of a the given link 
* on second call for the link the chosen person is loaded from `draw.txt`

## ChatGPT prompt
Here's a detailed prompt to generate the updated version of the HTML code:

---

**Prompt:**

Create an HTML page titled **"Weihnachtswichteln"** that has the following features:

1. **Loading Animation:**
   - The page starts with a loading animation for **5 seconds**.
   - The loading animation consists of:
     - An image (`https://cdn.pixabay.com/animation/2022/10/08/10/56/10-56-39-150_512.gif`), with a **maximum height of 50vh** to ensure responsiveness on mobile devices.
     - A loading text **"Ziehe ein Los für dich..."**, which has an animated color gradient effect (`linear-gradient`) and a **light grey background** (`rgba(0, 0, 0, 0.5)`). The text is padded and has rounded corners.

2. **Main Content After Loading:**
   - After 5 seconds, the main content is displayed.
   - This content includes:
     - A responsive image (`https://cdn.pixabay.com/animation/2023/11/28/15/39/15-39-31-812_512.gif`) with **maximum height of 50vh**.

3. **PHP Script for Key-Value Lookup:**
   - The user provides a `key` as a query parameter (`?key=value`).
   - The script reads from two files:
     - `data.txt`: Contains key-value pairs.
     - `draw.txt`: Tracks previously drawn keys.
   - If the key is found in `draw.txt`:
     - The corresponding key from `data.txt` is fetched, and its value is displayed.
   - If the key is not in `draw.txt`:
     - A random key from `data.txt` is chosen, excluding the given query key and previously used keys.
     - The selected value is displayed.
     - The `draw.txt` file is updated to record the mapping of the original key to the random key.

4. **Responsive Design:**
   - The page is designed to be **responsive**:
     - All content is centered horizontally and vertically using **flexbox**.
     - Text, images, and other elements are appropriately scaled to fit both desktop and mobile screens.
   - The page background color is **black**, and the result text color is **light grey** for contrast.

5. **Styling:**
   - Use **modern, clean styles**:
     - Font is **Arial**, and the entire page is centered.
     - The main content (`#content`) is initially hidden and revealed after the loading animation.
     - The result text (`#result`) has a larger font size (`2em`), is light grey, and wraps neatly within its container.

6. **JavaScript to Handle the Loading Animation:**
   - Include a **JavaScript function** to display the loading screen for **5 seconds** before revealing the main content.

---

This prompt will create a responsive HTML page with a loading animation, PHP-based key-value lookup functionality, and visually appealing styles. The page is optimized for both desktop and mobile devices.



## Credits
**Both images are created and provided by:**
Dieses Bild findest du hier: (Pixabay | Lizenzdetails)[https://pixabay.com/service/license-summary/]
Ersteller: Winterflower | Credit: Image by Winterflower
Urheberrecht: Winterflower