const userId = Number(document.querySelector(".us-id").innerHTML);

function loadConnectedPeers() {
  if (userId !== undefined) {
    $.post(`/VChat/loadconnection/${userId}`);
  }
}

conn.onopen = function (e) {
  console.log("Connection established!");
};

conn.onmessage = function (e) {
  const data = JSON.parse(e.data);

  switch (data.type) {
    case "CONNECTION_ESTABLISHED":
      loadConnectedPeers();
      break;
  }
  console.log(data);
};
