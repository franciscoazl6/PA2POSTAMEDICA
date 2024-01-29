import 'package:flutter/material.dart';
import 'package:get/get.dart';

class ChatPage extends StatefulWidget {
  @override
  State createState() => ChatScreenState();
}

class ChatScreenState extends State<ChatPage> {
  final List<ChatMessage> _messages = <ChatMessage>[];
  final TextEditingController _textController = TextEditingController();

  bool firstMessageSent = false;

  void _handleSubmitted(String text) {
    _textController.clear();
    ChatMessage message = ChatMessage(
      text: text,
    );
    setState(() {
      _messages.insert(0, message);
      _handleAutoResponse(text);
    });
  }

  void _handleAutoResponse(String text) {
    if (!firstMessageSent) {
      // Respuesta para el primer mensaje
      _addAutoResponse('Hola, ¿cómo estás?');
      firstMessageSent = true;
    } else {
      // Respuesta para los mensajes siguientes
      _addAutoResponse('Disculpe, no entiendo. ¿Puede ser más claro, por favor?');
    }
  }

  void _addAutoResponse(String text) {
    ChatMessage autoResponse = ChatMessage(
      text: text,
      isAutoResponse: true,
    );
    _messages.insert(0, autoResponse);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('CHAT BOT MEDICO'),
      ),
      body: Column(
        children: <Widget>[
          Flexible(
            child: ListView.builder(
              padding: EdgeInsets.all(8.0),
              reverse: true,
              itemBuilder: (_, int index) => _messages[index],
              itemCount: _messages.length,
            ),
          ),
          Divider(height: 1.0),
          Container(
            decoration: BoxDecoration(
              color: Theme.of(context).cardColor,
            ),
            child: _buildTextComposer(),
          ),
        ],
      ),
    );
  }

  Widget _buildTextComposer() {
    return IconTheme(
      data: IconThemeData(color: Theme.of(context).canvasColor),
      child: Container(
        margin: EdgeInsets.symmetric(horizontal: 8.0),
        child: Row(
          children: <Widget>[
            Flexible(
              child: TextField(
                controller: _textController,
                onSubmitted: _handleSubmitted,
                decoration: InputDecoration.collapsed(
                  hintText: 'Enviar mensaje',
                ),
              ),
            ),
            IconButton(
              icon: Icon(Icons.send),
              onPressed: () => _handleSubmitted(_textController.text),
            ),
          ],
        ),
      ),
    );
  }
}

class ChatMessage extends StatelessWidget {
  final String text;
  final bool isAutoResponse;

  ChatMessage({required this.text, this.isAutoResponse = false});

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: EdgeInsets.symmetric(vertical: 10.0),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: <Widget>[
          Container(
            margin: const EdgeInsets.only(right: 16.0),
            child: CircleAvatar(
              child: Text('G'),
            ),
          ),
          Expanded(
            child: Column(
              crossAxisAlignment: isAutoResponse
                  ? CrossAxisAlignment.end
                  : CrossAxisAlignment.start,
              children: <Widget>[
                Text(
                  'Geraldine',
                  style: Theme.of(context).textTheme.subtitle1,
                ),
                Container(
                  margin: EdgeInsets.only(top: 5.0),
                  child: Text(
                    text,
                    style: TextStyle(
                      color: isAutoResponse ? Colors.green : null,
                      fontWeight: isAutoResponse ? FontWeight.bold : null,
                    ),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
