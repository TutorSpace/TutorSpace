from bs4 import BeautifulSoup, NavigableString
import requests
import pandas


def scrape_math_tags(page_url):
    page = requests.get(page_url)
    soup = BeautifulSoup(page.text, 'html.parser')
    tag_list = soup.find_all('b')
    res_list = []
    for tag in tag_list:
        tag_text = tag.text.strip()
        if len(tag_text) > 1:
            res_list.append(tag_text[:-1])
    return res_list


def scrape_wiki_tags(page_url):
    page = requests.get(page_url)
    soup = BeautifulSoup(page.text, 'html.parser')
    tag_list = soup.find_all('dt')
    res_list = []
    for tag in tag_list:
        tag_text = tag.text.strip()
        if len(tag_text) > 1:
            res_list.append(tag_text)
    return res_list


def scrape_neuroscience_tags(page_url):
    page = requests.get(page_url)
    soup = BeautifulSoup(page.text, 'html.parser')
    tag_list = soup.find_all('strong')
    res_list = []
    for tag in tag_list:
        tag_text = tag.text.strip()
        if len(tag_text) > 1:
            res_list.append(tag_text)
    return res_list[1:-3]


def scrape_prog_lang_tags(page_url):
    page = requests.get(page_url)
    soup = BeautifulSoup(page.text, 'html.parser')
    tag_list = soup.find_all('div', class_="div-col columns column-width")
    res_list = []
    for set_item in tag_list:
        for tag in set_item.contents:
            if isinstance(tag, NavigableString):
                continue
            for li in tag.contents:
                if isinstance(li, NavigableString):
                    continue
                tag_text = li.text.strip()
                if len(tag_text) > 1:
                    res_list.append(tag_text)
    return res_list


if __name__ == '__main__':
    tags = []

    url = "https://www.storyofmathematics.com/glossary.html"
    tags += scrape_math_tags(url)

    url = "https://en.wikipedia.org/wiki/Glossary_of_biology"
    tags += scrape_wiki_tags(url)

    url = "https://en.wikipedia.org/wiki/Glossary_of_physics"
    tags += scrape_wiki_tags(url)

    url = "https://en.wikipedia.org/wiki/Glossary_of_chemistry_terms"
    tags += scrape_wiki_tags(url)

    url = "https://en.wikipedia.org/wiki/Glossary_of_computer_science"
    tags += scrape_wiki_tags(url)

    url = "https://en.wikipedia.org/wiki/Glossary_of_electrical_and_electronics_engineering"
    tags += scrape_wiki_tags(url)

    url = "https://www.dana.org/explore-neuroscience/brain-basics/key-brain-terms-glossary/"
    tags += scrape_neuroscience_tags(url)

    url = "https://en.wikipedia.org/wiki/Glossary_of_geology"
    tags += scrape_wiki_tags(url)

    url = "https://en.wikipedia.org/wiki/Glossary_of_astronomy"
    tags += scrape_wiki_tags(url)

    url = "https://en.wikipedia.org/wiki/Glossary_of_economics"
    tags += scrape_wiki_tags(url)

    url = "https://en.wikipedia.org/wiki/List_of_programming_languages"
    tags += scrape_prog_lang_tags(url)

    tags += ['mathematics', 'biology', 'physics', 'chemistry', 'computer science', 'programming languages',
             'electrical engineering', 'neuroscience', 'geology', 'astronomy', 'economics', 'GRE', 'GMAT']

    tags = list(set(tags))

    print(tags)

    df = pandas.DataFrame(tags, columns=['tag'])
    df.to_csv(r"tags.csv")

