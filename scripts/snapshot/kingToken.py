class Token:

    def __init__(self, token):
        self.token = token

    def __str__(self):
        return self.token

    def __repr__(self):
        return self.__str__()