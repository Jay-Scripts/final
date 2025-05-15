async function sendMessage() {
  const input = document.getElementById("userInput").value;
  const responseDiv = document.getElementById("responseDiv");
  if (!input) {
    responseDiv.innerHTML =
      "<span class='text-red-500'>Please enter a message.</span>";
    return;
  }
  responseDiv.innerHTML =
    "<span class='animate-pulse text-[#00503c]'>Loading...</span>";
  try {
    const response = await fetch(
      "https://openrouter.ai/api/v1/chat/completions",
      {
        method: "POST",
        headers: {
          Authorization:
            "Bearer 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",
          "HTTP-Referer": "http://localhost",
          "X-Title": "Test App",
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          model: "deepseek/deepseek-r1:free",
          messages: [
            {
              role: "system",
              content: `ang sagot ay tagalog lamang, 5 suggestion kasama ang benepisyong nutrients preformat answer at suggest ng healthy na pagkain base sa halagang ito 
`,
            },
            {
              role: "user",
              content: input,
            },
          ],
        }),
      }
    );

    const data = await response.json();
    const markdownText =
      data.choices?.[0]?.message?.content || "No response received.";
    responseDiv.innerHTML = markdownText.replace(/\n/g, "<br>");
  } catch (error) {
    responseDiv.innerHTML =
      "<span class='text-red-500'>Error: " + error.message + "</span>";
  }
}
// Allow pressing Enter to send
document.getElementById("userInput").addEventListener("keydown", function (e) {
  if (e.key === "Enter") sendMessage();
});
