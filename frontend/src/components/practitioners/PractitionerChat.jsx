import React, { useState } from 'react';
import {
    Dialog, DialogTitle, DialogContent, DialogActions,
    Button, TextField, Box, IconButton,
    List, ListItem, ListItemText, ListItemAvatar, Avatar
} from '@mui/material';
import { Send as SendIcon, Image as ImageIcon } from '@mui/icons-material';

const PractitionerChat = ({ open, onClose, practitioner }) => {
    const [messages, setMessages] = useState([]);
    const [messageInput, setMessageInput] = useState('');

    const handleSendMessage = () => {
        if (messageInput.trim() !== '') {
            setMessages([...messages, { text: messageInput, sender: 'user' }]);
            setMessageInput('');
        }
    };

    const handleImageUpload = () => {
        alert('Image upload functionality not implemented yet.');
    };

    return (
        <Dialog open={open} onClose={onClose} fullWidth maxWidth="md">
            <DialogTitle>Chat with {practitioner ? `Practitioner #${practitioner.id}` : 'Practitioner'}</DialogTitle>
            <DialogContent>
                <List>
                    {messages.map((message, index) => (
                        <ListItem key={index} alignItems="flex-start">
                            <ListItemAvatar>
                                <Avatar alt={message.sender} src="/static/images/avatar/1.jpg" />
                            </ListItemAvatar>
                            <ListItemText
                                primary={message.text}
                                secondary={
                                    <React.Fragment>
                                        <Typography
                                            sx={{ display: 'inline' }}
                                            component="span"
                                            variant="body2"
                                            color="text.primary"
                                        >
                                            {message.sender === 'user' ? 'You' : 'Practitioner'}
                                        </Typography>
                                    </React.Fragment>
                                }
                            />
                        </ListItem>
                    ))}
                </List>
                <Box sx={{ display: 'flex', alignItems: 'center', mt: 2 }}>
                    <TextField
                        fullWidth
                        label="Type your message"
                        variant="outlined"
                        value={messageInput}
                        onChange={(e) => setMessageInput(e.target.value)}
                    />
                    <IconButton color="primary" onClick={handleImageUpload}>
                        <ImageIcon />
                    </IconButton>
                    <IconButton color="primary" onClick={handleSendMessage}>
                        <SendIcon />
                    </IconButton>
                </Box>
            </DialogContent>
            <DialogActions>
                <Button onClick={onClose}>Close</Button>
            </DialogActions>
        </Dialog>
    );
};

export default PractitionerChat;